The intention of this program is to convert an existing Guide to Pharmacology database into RDF data.

To achieve this we make use of the language R2RML and the platform Morph-RDB.

R2RML Paper: https://www.w3.org/TR/r2rml/

RDF Paper: https://www.w3.org/RDF/

Morph Github: https://github.com/oeg-upm/morph-rdb.

Our Platform also makes use of HCLS Dataset Descriptions to provide metadata describing the data produced
by our R2RML mappings.

HCLS Dataset Descriptions Paper: https://www.w3.org/TR/hcls-dataset/

//////////////////////////////////////////////////////////////////////////////////////////////////////

Generating Guide to Pharmacology RDF Dump

//////////////////////////////////////////////////////////////////////////////////////////////////////

Before running the program: 

Go to \Morph\Guide2Pharma and edit the database configuration in each morph.property file to fit your own.

You may then run the batch file 'generate', which will parse the three R2RML scripts into three different output files,
and generate the appropriate HCLS dataset descriptions.

After this, the RDF dump is complete and you may view the data from the files generated in the Output folder.

The script will then run HCLS.php, which will generate appropriate metadata following those defined by the HCLS communutity
profile, while asking for user input to define: RDF version, data source version, issue data and creation date.
The issue and creation dates may be in the future, should you want them to be.

//////////////////////////////////////////////////////////////////////////////////////////////////////

Modifying RDF Output Using R2RML Mappings.

//////////////////////////////////////////////////////////////////////////////////////////////////////

To generate our RDF output, we use R2RML which allows us to convert entire tables, views or just query results to RDF data.

For our examples we use queries using the rr:sqlQuery function, to limit the data returned. Because of this it is very easy 
for us to modify the output from our scripts by updating these queries to withdraw more or less data.

R2RML allows two ways to create triples using subject maps and predicate / object maps.

When creating a literal value such as a string, use a column based value such as [rr:column "name";] where 'name' is the name of some column
used in the associated query.

When creating a URI based value, use a template value such as [rr:template ""http://www.guidetopharmacology.com/data/ligand{id}"";] where 'id'
is the name of a column used in the associated query. You can use multiple column values to form a template such as [rr:template "{namespace}{external_id}";]

We use SQL cases where necessary to manipulate values, this means that no modification of data in the database is necessary before we can run the RDF conversion,
these cases can be seen throughout our R2RML mapping files and allow us to assign values based on the value of a returned field.

We can also create blank nodes using [rr:termType rr:blankNode;] when describing a subject or object. This can be used to create pairs or groups of data
in RDF, currently we use blank nodes for UniProt references paired with Taxonomies & interaction affinities which require values and units.
 

//////////////////////////////////////////////////////////////////////////////////////////////////////

Modifying HCLS Dataset Descriptions

//////////////////////////////////////////////////////////////////////////////////////////////////////

Currently our HCLS generator asks for input for the common changes - version number and different dates - should other
descriptors such as licenses need changed (or added), this can be done by editing our HCLS.php file. This is split into different 
segments for gathering variables, opening files, setting input and writing to appropriate files.

//////////////////////////////////////////////////////////////////////////////////////////////////////

BioAssay Ontology for Units

//////////////////////////////////////////////////////////////////////////////////////////////////////

During the development of our platform, the units pKi, pKB and pKd were not described by any existing ontology. We have contacted the
Personel behind the BioAssay ontology, and they are currently working on it. However, because the units are not available these are currently assigned
placeholder values in our interaction R2RML files, in Triples Maps 4&5. This can be easily edited to fit the BAO ontology, once it is updated by editing
the associated SQL case statements.The intention of this program is to convert an existing Guide to Pharmacology database into RDF data.

To achieve this we make use of the language R2RML and the platform Morph-RDB.

R2RML Paper: https://www.w3.org/TR/r2rml/

RDF Paper: https://www.w3.org/RDF/

Morph Github: https://github.com/oeg-upm/morph-rdb.

Our Platform also makes use of HCLS Dataset Descriptions to provide metadata describing the data produced
by our R2RML mappings.

HCLS Dataset Descriptions Paper: https://www.w3.org/TR/hcls-dataset/

//////////////////////////////////////////////////////////////////////////////////////////////////////

Generating Guide to Pharmacology RDF Dump

//////////////////////////////////////////////////////////////////////////////////////////////////////

Before running the program: 

Go to \Morph\Guide2Pharma and edit the database configuration in each morph.property file to fit your own.

You may then run the batch file 'generate', which will parse the three R2RML scripts into three different output files,
and generate the appropriate HCLS dataset descriptions.

After this, the RDF dump is complete and you may view the data from the files generated in the Output folder.

The script will then run HCLS.php, which will generate appropriate metadata following those defined by the HCLS communutity
profile, while asking for user input to define: RDF version, data source version, issue data and creation date.
The issue and creation dates may be in the future, should you want them to be.

//////////////////////////////////////////////////////////////////////////////////////////////////////

Modifying RDF Output Using R2RML Mappings.

//////////////////////////////////////////////////////////////////////////////////////////////////////

To generate our RDF output, we use R2RML which allows us to convert entire tables, views or just query results to RDF data.

For our examples we use queries using the rr:sqlQuery function, to limit the data returned. Because of this it is very easy 
for us to modify the output from our scripts by updating these queries to withdraw more or less data.

R2RML allows two ways to create triples using subject maps and predicate / object maps.

When creating a literal value such as a string, use a column based value such as [rr:column "name";] where 'name' is the name of some column
used in the associated query.

When creating a URI based value, use a template value such as [rr:template ""http://www.guidetopharmacology.com/data/ligand{id}"";] where 'id'
is the name of a column used in the associated query. You can use multiple column values to form a template such as [rr:template "{namespace}{external_id}";]

We use SQL cases where necessary to manipulate values, this means that no modification of data in the database is necessary before we can run the RDF conversion,
these cases can be seen throughout our R2RML mapping files and allow us to assign values based on the value of a returned field.

We can also create blank nodes using [rr:termType rr:blankNode;] when describing a subject or object. This can be used to create pairs or groups of data
in RDF, currently we use blank nodes for UniProt references paired with Taxonomies & interaction affinities which require values and units.
 

//////////////////////////////////////////////////////////////////////////////////////////////////////

Modifying HCLS Dataset Descriptions

//////////////////////////////////////////////////////////////////////////////////////////////////////

Currently our HCLS generator asks for input for the common changes - version number and different dates - should other
descriptors such as licenses need changed (or added), this can be done by editing our HCLS.php file. This is split into different 
segments for gathering variables, opening files, setting input and writing to appropriate files.

//////////////////////////////////////////////////////////////////////////////////////////////////////

BioAssay Ontology for Units

//////////////////////////////////////////////////////////////////////////////////////////////////////

During the development of our platform, the units pKi, pKB and pKd were not described by any existing ontology. We have contacted the
Personel behind the BioAssay ontology, and they are currently working on it. However, because the units are not available these are currently assigned
placeholder values in our interaction R2RML files, in Triples Maps 4&5. This can be easily edited to fit the BAO ontology, once it is updated by editing
the associated SQL case statements.


