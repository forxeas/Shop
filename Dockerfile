FROM ubuntu:latest
LABEL authors="forem"

ENTRYPOINT ["top", "-b"]
