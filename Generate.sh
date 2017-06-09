cd Morph
java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma ligand.morph.properties
java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma target.morph.properties
java -cp morph-rdb.jar:lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma interaction.morph.properties
cd ..
cp Morph/Guide2Pharma/Output/ligand.n3 Data/ligand.n3
cp Morph/Guide2Pharma/Output/target.n3 Data/target.n3
cp Morph/Guide2Pharma/Output/interaction.n3 Data/interaction.n3

php HCLS.php
