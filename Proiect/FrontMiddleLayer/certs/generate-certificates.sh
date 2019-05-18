
#!/bin/bash
#######################################################################################################
#If you get a Syntax error: "(" unexpected it means that /bin/sh is pointing to dash instead of bash, #
# do the following:                                                                                   #
# ls -l /bin/sh                                                                                       #
# sudo mv /bin/sh /bin/sh.back                                                                        #
# ls -l /bin/sh.back                                                                                  #
# sudo ln -s /bin/bash /bin/sh                                                                        #
# ls -l /bin/sh                                                                                       #
#######################################################################################################
#
# set values for certificate DNs
# note: CN is set to different values in the sections below
ORG="000_QRit_Certificates"

# set values that the commands will share
VALID_DAYS=360
CA_KEY=ca.key
CA_CERT=ca.crt
CLIENT_KEY=client.key
CLIENT_CERT=client.crt
CLIENT_CSR=client.csr
CLIENT_P12=client.p12
SERVER_KEY=server.key
SERVER_CERT=server.crt
SERVER_CSR=server.csr
KEY_BITS=2048
FINGERPRINT=sha512
CA_CERT_PEM=ca.pem

echo
echo "Create CA certificate..."
CN="Test CA"
C="RO"
ST="Iasi"
L="Iasi"
OU="Developpment"
openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:$KEY_BITS -out $CA_KEY
openssl req -new -x509 -$FINGERPRINT -days $VALID_DAYS -key $CA_KEY -subj "/CN=$CN/O=$ORG/OU=$OU" -out $CA_CERT
openssl x509 -in $CA_CERT  -out $CA_CERT_PEM -outform PEM

echo "Done."

echo
echo "Creating Server certificate..."
CN="localhost"
openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:$KEY_BITS -out $SERVER_KEY
openssl req -new -$FINGERPRINT -key $SERVER_KEY -subj "/CN=$CN/O=$ORG/OU=$OU" -out $SERVER_CSR
echo "Done"
echo
echo "----- Don't forget to open your browser and install your $CA_CERT certificates -----"
echo
echo "Run the next command form terminal to create the server certificate file"
#openssl x509 -req -extfile <(printf "subjectAltName=DNS.1:localhost,IP.1=192.168.1.101") -days $VALID_DAYS -in $SERVER_CSR -CAcreateserial -CA $CA_CERT -CAkey $CA_KEY -$FINGERPRINT -out $SERVER_CERT
echo
echo 'openssl x509 -req -extfile <(printf "subjectAltName=DNS.1:localhost,IP.1:192.168.1.101,IP.2:192.168.100.7,IP.3:10.37.253.163") -days 365 -in server.csr -CA ca.crt -CAkey ca.key -CAcreateserial -sha512 -out server.crt'
echo
echo "Test using:"
echo
echo "openssl x509 -in server.crt -text -noout"
#openssl x509 -extfile $EXT_FILE -days $VALID_DAYS -req -in $SERVER_CSR -CAcreateserial -CA $CA_CERT -CAkey $CA_KEY -$FINGERPRINT -out $SERVER_CERT


#echo
#echo "Creating Client certificate..."
#CN="Test User 1"
#USER_ID="testuser1"
#P12_PASSWORD=
#openssl genpkey -algorithm RSA -pkeyopt rsa_keygen_bits:$KEY_BITS -out $CLIENT_KEY
#openssl req -new -$FINGERPRINT -key $CLIENT_KEY -subj "/CN=$CN/O=$ORG/OU=$OU/UID=$USER_ID" -out $CLIENT_CSR
#openssl x509 -days $VALID_DAYS -req -in $CLIENT_CSR -CAcreateserial -CA $CA_CERT -CAkey $CA_KEY  -$FINGERPRINT -out $CLIENT_CERT
#openssl pkcs12 -in $CLIENT_CERT -inkey $CLIENT_KEY -export -password pass:$P12_PASSWORD -out $CLIENT_P12
#echo "Done"

