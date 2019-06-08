IMAGE_NAME=eccod/xampp
CONTAINER_NAME=xamppy-docker
PUBLIC_WWW_DIR='~/web_pages'


echo "Running container '$CONTAINER_NAME' from image '$IMAGE_NAME'..."


docker start $CONTAINER_NAME > /dev/null 2> /dev/null || {
	echo "Creating new container..."
	docker run \
	       --detach \
	       --tty \
	       -p 8080:80 \
	       -p 3306:3306 \
	       --name $CONTAINER_NAME \
	       --mount "source=$CONTAINER_NAME-vol,destination=/opt/lampp/var/mysql/" \
			$IMAGE_NAME
}

echo "server at: http://localhost:8080/www"
echo "xampp interface at: mysql://localhost:3306"

if [ "$#" -eq  "0" ]; then
	docker exec --interactive --tty $CONTAINER_NAME bash
elif [ "$1" = "stop" ]; then
	docker stop $CONTAINER_NAME
else
	docker exec $CONTAINER_NAME $@
fi


