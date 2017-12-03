#!/bin/bash

docker_names=(wordpress wordpress_db phpmyadmin)
for i in "${docker_names[@]}"
do
    docker stop $(docker ps -aq --filter name="${i}$")
done

echo "Containers: ['wordpress', 'wordpress_db', 'phpmyadmin'] have been stopped."