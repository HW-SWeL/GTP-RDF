FROM ubuntu:16.04

# Where to download from
ENV BASE http://www.macs.hw.ac.uk/~ajg33/GTP/

RUN apt-get update && DEBIAN_FRONTEND=noninteractive apt-get install -y wget aria2

RUN mkdir /download
WORKDIR /download
COPY download.sh /usr/local/bin/

VOLUME /download
# Expose for linking
VOLUME /staging

RUN mkdir -p /staging
COPY staging.sql /staging/

CMD ["/usr/local/bin/download.sh"]
