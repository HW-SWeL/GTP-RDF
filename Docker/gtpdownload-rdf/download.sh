#!/bin/bash
set -e

# BASE variable inherited from Dockerfile
echo "Downloading data from $BASE"

cd /download

if [ -f .downloaded ] ; then
  echo "Already downloaded, nothing more to do."
  echo "To force new download, delete /download/.downloaded"
  exit 0
fi
wget -e robots=off --no-verbose --recursive --no-directories -A '*.tar.gz' --no-parent $BASE

echo "Extracting to /staging"
mkdir -p /staging
cd /staging

for x in /download/*tar.gz ; do
  echo Extracting from $x
  tar xzfv $x
  # Delete extracted tar file so it won't be downloaded+extracted again
#  rm -f $x
done
touch .downloaded
echo "Data download complete"
