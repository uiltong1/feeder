# base image
FROM node:18.19.0

RUN npm install -g http-server

# set working directory
WORKDIR /app

# add `/app/node_modules/.bin` to $PATH
ENV PATH /app/node_modules/.bin:$PATH

# install and cache app dependencies
COPY ./frontend/package*.json /app/
COPY ./frontend/ .

RUN npm install --g @vue/cli

RUN npm install

# start app
CMD ["npm", "run", "serve"]