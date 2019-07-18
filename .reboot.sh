docker-machine start Camagru;
eval $(docker-machine env Camagru) && docker restart $(docker ps -aq)
