cd Morph
java -cp morph-rdb.jar;lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma ligand.morph.properties
java -cp morph-rdb.jar;lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma target.morph.properties
java -cp morph-rdb.jar;lib/* es.upm.fi.dia.oeg.morph.r2rml.rdb.engine.MorphRDBRunner Guide2Pharma interaction.morph.properties
cd ..
copy Morph\Guide2Pharma\Output\ligand.n3 Output\ligand.n3
copy Morph\Guide2Pharma\Output\target.n3 Output\target.n3
copy Morph\Guide2Pharma\Output\interaction.n3 Output\interaction.n3
php HCLS.php