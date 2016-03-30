package main

import (
	"io"
	"log"
	"net/http"
	"net/url"

	"github.com/dgrijalva/jwt-go"
)

func auth(w http.ResponseWriter, req *http.Request) {
	var (
		username string
		password string
		userId   string
	)

	if req.Method != "GET" {
		w.WriteHeader(415)
		io.WriteString(w, "method not allowed (try GET)")
		return
	}

	mySharedSecret := []byte("foxtrot")
	queryParams := req.URL.Query()

	redirectUri := queryParams.Get("redirect_uri")
	if redirectUri == "" {
		w.WriteHeader(400)
		io.WriteString(w, "'redirect_uri' query param missing")
		return
	}

	state := queryParams.Get("state")
	if state == "" {
		w.WriteHeader(400)
		io.WriteString(w, "'state' query param missing")
		return
	}

	token := queryParams.Get("token")
	if token == "" {
		w.WriteHeader(400)
		io.WriteString(w, "'token' query param missing")
		return
	}

	incomingToken, err := jwt.Parse(token, func(t *jwt.Token) (interface{}, error) {
		return mySharedSecret, nil
	})
	if err != nil {
		log.Println(err)
		w.WriteHeader(400)
		io.WriteString(w, "[error] jwt.Parse - see logs")
		return
	}

	rawData := incomingToken.Claims["data"]
	m, ok := rawData.(map[string]interface{})
	if !ok {
		log.Println("token.data was: %#v", rawData)
		w.WriteHeader(500)
		io.WriteString(w, "[error] token.data type assertion - see logs")
		return
	}

	for key, value := range m {
		switch value := value.(type) {
		case string:
			if key == "username" {
				username = value
			} else if key == "password" {
				password = value
			}
		default:
			log.Printf("token.data.%s was: %#v", key, value)
			w.WriteHeader(400)
			io.WriteString(w, "[error] token.data type switch mismatch - see logs")
			return
		}
	}

	// TODO: Authenticate your own real users here
	if username == "dan" && password == "123" {
		userId = "user-from-golang"
	} else {
		w.WriteHeader(401)
		io.WriteString(w, "[error] unauthorized")
		return
	}

	outgoingToken := jwt.New(jwt.SigningMethodHS256)
	outgoingToken.Claims["user_id"] = userId

	outgoingTokenSS, err := outgoingToken.SignedString(mySharedSecret)
	if err != nil {
		log.Println(err)
		w.WriteHeader(500)
		io.WriteString(w, "[error] token.SignedString - see logs")
		return
	}

	params := url.Values{}
	params.Add("token", outgoingTokenSS)
	params.Add("state", state)
	// TODO: Take out the redirect_uri parameter before production
	params.Add("redirect_uri", "https://api.ionic.io/auth/integrations/custom/success")

	http.Redirect(w, req, redirectUri+"&"+params.Encode(), http.StatusFound)
}

func main() {
	http.HandleFunc("/auth", auth)
	log.Fatal(http.ListenAndServe(":5000", nil))
}
