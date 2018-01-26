#!/bin/bash

cd "$(dirname "$0")"

HOST_WRITE=${1:-true}
STATUS=$(docker-machine status wordpress-vm 2> /dev/null || echo "Off")
if [[ $STATUS == 'Off' ]];
then
   docker-machine create --driver virtualbox wordpress-vm
elif [[ $STATUS == "Running" ]];
then
  docker-machine restart wordpress-vm
else
    echo "Hmm something didn't work right... retrying."
    # sudo ifconfig vboxnet0 down; sudo ifconfig vboxnet0 up
    docker-machine rm wordpress-vm -y
    docker-machine create --driver virtualbox wordpress-vm
    /bin/bash ./stop.sh
fi

eval "$(docker-machine env wordpress-vm)"
mkdir ./hold_temp
cp -r ./wordpress/wp-content ./wordpress/wp-config.php ./hold_temp
rm -rf ./wordpress
curl -O https://wordpress.org/latest.tar.gz
tar xzvf latest.tar.gz
rm -rf {latest.tar.gz,./wordpress/wp-content}
cp -r ./hold_temp/wp-content ./hold_temp/wp-config.php ./wordpress
rm -rf ./hold_temp

if [[ $STATUS == 'Running' ]];
then
  docker-compose up -d
else
  docker-compuse up -d --force-recreate
fi

docker exec -it wordpress usermod -u 1000 www-data

host=$(docker-machine env wordpress-vm | grep "DOCKER_HOST")
hostSplit=(${host//:/ })
ips=(${hostSplit[4]:2} ${hostSplit[4]:2}:8181)

echo ""
if ([[ "$(uname -s)" == "Darwin" ]] || [["$(uname -s)" == "Linux"]]) && $HOST_WRITE; then
  # need a way to either get a reverse proxy, or to get each container their own IP through docker's network
  #sites=(wordpress.site phpmyadmin.site)
  hosts_file=$([ "$(uname)" == "Darwin" ] && echo "/private/etc/hosts" || echo "/etc/hosts")
  sites=(wordpress.site)
  for i in "${!sites[@]}"
  do
      current_ip=$(grep -r "${sites[i]}" ${hosts_file} 2> /dev/null || echo "none")
      if [[ $current_ip == "none" ]]; then
        sudo -- bash -c -e "echo '${ips[i]} ${sites[i]}' >> ${hosts_file}";
      else
        string=$(grep -r "${sites[i]}" ${hosts_file})
        stringSplit=(${string// / })
        stringSplitAgain=(${stringSplit[0]//:/ })
        sudo -- bash -c -e "grep -r -l ${stringSplitAgain[1]} ${hosts_file} | xargs sed -i \"\" \"s/${stringSplitAgain[1]}/${ips[i]}/g\""
      fi
  done
  echo "WEBSITE: wordpress.site"
  #echo "PHPMYADMIN: phpmyadmin.site"
  echo "PHPMYADMIN: wordpress.site:8181"
else
  echo "WEBSITE: ${ips[0]}"
  echo "PHPMYADMIN: ${ips[1]}"
fi