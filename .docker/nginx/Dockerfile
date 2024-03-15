FROM python:3.8

ENV LC_MONETARY=pt_BR.UTF-8 \
    PYTHONDONTWRITEBYTECODE=1 \
    PYTHONUNBUFFERED=1 \
    SERVICE_PORT=8800

RUN apt-get update -yy \
    && apt-get upgrade -yy \
    && apt-get install -y \
        locales \
        locales-all

RUN locale-gen $LC_MONETARY
RUN pip install --upgrade pip

RUN pip install uvicorn

RUN apt install nginx nginx-common -yy 
RUN apt install supervisor -yy

# NGINX CONF
ADD default.conf /etc/nginx/conf.d/default.conf

CMD ["nginx", "-g", "daemon off;"]