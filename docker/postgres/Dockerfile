FROM postgres:10.5

ENV TIMEZONE=UTC

RUN ln -snf /usr/share/zoneinfo/$TIMEZONE /etc/localtime && echo $TIMEZONE > /etc/timezone

COPY init.sql /docker-entrypoint-initdb.d