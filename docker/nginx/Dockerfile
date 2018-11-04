FROM nginx:1.14.0

ENV TIMEZONE=UTC

COPY nginx.conf /etc/nginx/nginx.conf
COPY tracker.local.conf /etc/nginx/conf.d/tracker.local.conf

RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone