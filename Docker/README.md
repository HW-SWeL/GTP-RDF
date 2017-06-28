# GTP Docker Images

- [x] Get virtuoso and data container running and check in
- [ ] Work on data download and data loading containers
      - [ ] Data download does not seem to be firing it is created but nothing ends up in the logs
      - [ ] Data staging seems to be running, no files are in the staging directory so no data is being loaded beyond the basic virtuoso data

The [Guide to Pharmacology](http://www.guidetopharmacology.org/) database is available as [linked data](https://www.w3.org/standards/semanticweb/data). The platform that supports the linked data platform is installed as a series of [Docker](http://docker.com/) containers.

- [Overview](#overview)
- [Requirements](#requirements)
- [Retrieving GTP Docker Images](#retrieving-gtp-docker-images)
- [Data Containers](#data-containers)
- [GTP Platform Commands](#GTP-platform-commands)
  - [Running the GTP Platform](#running-the-gtp-platform)
  - [Checking the Status of the GTP Platform](#checking-the-status-of-the-GTP-platform)
  - [Stopping the GTP Platform](#Stopping-the-GTP-platform)
- [Upgrading the GTP Platform](#Upgrading-the-GTP-Platform)

## Overview

A *Docker container* is a kind of sandboxed Linux environment, which typically runs a single server instance, e.g. mySQL. Each Container has its own virtual filesystem, which is realized from *Docker images*, downloaded from the central [Docker Hub Registry](https://registry.hub.docker.com/).

The Guide to Pharacology Docker Images provide the different services that form the Guide to Pharmacology Linked Data platform. This page describes how these Docker containers can be installed and started using [Docker Compose](http://docs.docker.com/compose/).

The Guide to Pharmacology containers will download and use the latest data release, and provide the Virtuoso SPARQL endpoint and the [Lodestar Linked Data explorer](http://ebispot.github.io/lodestar/) developed by the [EBI](http://www.ebi.ac.uk/).

The Guide to Pharmacology Docker Images and these instructions are based on the [Open PHACTS Docker Images](https://github.com/openphacts/ops-docker/blob/121f73d4cb561e1557c050f5ccb97db08b3c0a0d/README.md). Modifications were made based on the documentation of the [Virtuoso Docker Image](https://hub.docker.com/r/stain/virtuoso/).

## Requirements

- [Docker](https://docs.docker.com/installation/#installation) 1.7.1 or later
- [Docker Compose](http://docs.docker.com/compose/install/) 1.5.2 or later
- Fast Internet connection (during build of data containers)


The commands in these instructions assume that the user has been given permission to run docker and docker compose commands.

*Hint: If you add your username to the docker group, as suggested by the Docker install, and log out and in again, you can run the remaining docker and docker-compose commands without using sudo. Note that this would effectively be giving that user privileged root access to the host machine without password verification.*

## Retrieving GTP Docker Images

The docker compose file `docker-compose.yml` contains the configuration for building the GTP Docker Images. To download the latest version of the Docker images used in the Guide to Pharmacology Linked Data Platform run the command

```
docker-compose pull
```

This will download:

- [busybox](https://hub.docker.com/_/busybox/): provides many common UNIX utilities in a single small package
- [stain/virtuoso](https://registry.hub.docker.com/u/stain/virtuoso/): provides the Open Source Edition of the Virtuoso Triple Store (Version 7)

To override the default configurations of the Docker images, e.g. to change the location of the data storage, then put your edits in a `docker-compose.override.yml` file instead. That way your configuration won't be changed when the `docker-compose.yml` is modified.

## Data Containers

The GTP Docker container uses separate [Data Volume Containers](http://docs.docker.com/userguide/dockervolumes/#creating-and-mounting-a-data-volume-container) to contain the Guide to Pharmacology RDF dataset. You should follow the instructions in one of the following subsections depending upon whether you are creating the data locally, or downloading the data.

### Data Creation Container

**TODO:** Create the data creation container, and the documentation, based on morphdb

The following command will create the GTP-RDF data from a local PostgreSQL database containing the Guide to Pharmacology data. The generated RDF will then be loaded into the Virtuoso triple store.

### Data Loading Container

The following command will download the GTP-RDF data from the GTP site and then load it into the Virtuoso triple store.

```docker-compose up -d virtuosostagingrdf```

To follow the progress, use:

```
docker-compose ps
docker-compose logs virtuosostagingrdf
```

Note that `docker-compose logs` may not terminate even if its contanier does, use *Ctrl-C* to cancel log listing.

## GTP Platform Commands

### Running the GTP Platform

To start the GTP platform:

```docker-compose up -d```

You can follow the progress by looking at the logs (press Ctrl-C to stop watching):

```docker-compose logs```

Once started, the following services will be exposed:

- http://localhost:8890/sparql - Virtuoso SPARQL endpoint

### Checking the Status of the GTP Platform

To check the status of the GTP Platform:

```docker-compose ps```

### Stopping the GTP Platform

To stop the platform:

```docker-compose stop```

### Removing the GTP Platform

To remove the GTP Platform:

```
docker-compose stop
docker-compose rm -v
```

To recover additional disk space by the docker images, and don't have any other non-running docker images you want to keep:

```
docker images -q | xargs docker rmi
```

Sometimes you might also need to remove all old containers - which would free up the images for the above:

```
docker ps -aq | xargs docker rm -v
```

## Upgrading the GTP Platform

Unless a new data release needs to be loaded, you do not need to repeat the staging. To upgrade the software within the docker images (e.g. newer virtuoso triple store), do:

```
docker-compose pull
```

Then rebuild the containers to use the newer images:

```
docker-compose up -d
```

If you need to restart staging from blank, then first remove their data volumes:

```
docker-compose rm -v virtuosodata
```

Then follow the procedure [Building data containers](#Data-Containers) above.