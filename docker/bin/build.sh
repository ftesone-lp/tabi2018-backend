#!/bin/bash

# script directory
DIR="$( cd "$( dirname "${BASH_SOURCE[0]}" )" >/dev/null 2>&1 && pwd )"

# docker build
docker build "$DIR/.." -t tabi2018/ftesone-backend:latest
