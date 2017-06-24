# GTP Docker Images

The [Guide to Pharmacology](http://www.guidetopharmacology.org/) database is available as [linked data](https://www.w3.org/standards/semanticweb/data). The platform that supports the linked data platform is installed as a series of [Docker](http://docker.com/) containers.

- [Overview](#overview)

## Overview

A *Docker container* is a kind of sandboxed Linux environment, which typically runs a single server instance, e.g. mySQL. Each Container has its own virtual filesystem, which is realized from *Docker images*, downloaded from the central [Docker Hub Registry](https://registry.hub.docker.com/).

The Guide to Pharacology Docker Images provide the different services that form the Guide to Pharmacology Linked Data platform. This page describes how these Docker containers can be installed and started using [Docker Compose](http://docs.docker.com/compose/).

The Guide to Pharmacology containers will download and use the latest data release, and provide the Virtuoso SPARQL endpoint and the [Lodestar Linked Data explorer](http://ebispot.github.io/lodestar/) developed by the [EBI](http://www.ebi.ac.uk/).

