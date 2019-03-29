from php:cli
MAINTAINER sidny <sidny@sidny.me>
ENV DDNS_ACCESS_KEY ''
ENV DDNS_ACCESS_SECRET ''
ENV	DDNS_DOMAIN ''
ENV	DDNS_SUBDOMAINS ''

COPY . /opt/aliddns
WORKDIR /opt/aliddns
CMD [ "/bin/bash", "ddns.sh" ]