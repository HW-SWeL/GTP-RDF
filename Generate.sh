#!/bin/bash

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

while getopts mg opt; do
  case $opt in
    m)
      echo "Generate metadata only"
      php HCLS.php
      exit 0
      ;;
    g)
      echo "Generate RDF data only"
      generate_rdf
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
