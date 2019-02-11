#!/bin/bash

update_ip(){
  CURRENT_IP=`ifconfig | grep -Eo 'inet (addr:)?([0-9]*\.){3}[0-9]*' | grep -Eo '([0-9]*\.){3}[0-9]*' | grep -v '127.0.0.1'`
  sed -i -e "s/[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}\.[0-9]\{1,3\}/$CURRENT_IP/g" .env
}

if [[ $1 == "up" ]]; then
  docker-compose up -d
  update_ip
  echo "Started checkpoint dev environment..."
  echo "IP address updated in .env file"
elif [[ $1 == "down" ]]; then
  docker-compose down
  echo "Stopped checkpoint dev environment"
else
  update_ip
  echo "IP address updated in .env file"
fi