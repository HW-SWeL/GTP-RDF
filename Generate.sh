#!/bin/bash
ENDPOINT="http://localhost:8080/rdf4j-server"
BASEURI_ENCODED="baseURI=%3Chttp%3A%2F%2Frdf.guidetopharmacology.org%2FGRAC%2F%3E"

#Function to generate the RDF version of Guide2Pharmacology data
generate_rdf() {
  cd Morph
  java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma ligand.morph.properties
  java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma target.morph.properties
  java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma interaction.morph.properties
  cd ..
  cp Morph/Guide2Pharma/Output/ligand.n3 Data/ligand.n3
  cp Morph/Guide2Pharma/Output/target.n3 Data/target.n3
  cp Morph/Guide2Pharma/Output/interaction.n3 Data/interaction.n3
  echo "Data generated and can be found in folder Data/"
}

#Function to load RDF data into designated triplestore
load_rdf() {
  echo "Loading data into triplestore:"
  url="$ENDPOINT/repositories/GRAC/statements?context=%3Curn%3Ax-local%3A$VERSION%3E&$BASEURI_ENCODED"
  echo -e "\tDeleting any existing triples in context <urn:x-local:$VERSION>"
  curl -X DELETE "$url"
  for file in Data/*.n3
  do
    echo -e "\t$file"
    curl -X POST -H 'Content-Type: text/n3; charset=utf-8' "$url" --upload-file "$file"
  done
  echo "Loading complete!"
}

while getopts glm opt; do
  case $opt in
    g)
      echo "Generate RDF data only"
      generate_rdf
      exit 0
      ;;
    l)
      load_rdf
      exit 0
      ;;
    m)
      echo "Generate metadata only"
      php HCLS.php
      exit 0
      ;;
    \?)
      echo "Invalid option: -$OPTARG"
      exit 1
      ;;
  esac
done
generate_rdf
php HCLS.php
