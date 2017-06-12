#!/usr/bin/php
<?php
/*
Liam Bruce 01/04/2017
Alasdair Gray

   Licensed under the Apache License, Version 2.0.
   you may not use this file except in compliance with the License.
   You may obtain a copy of the License at

       http://www.apache.org/licenses/LICENSE-2.0

   Unless required by applicable law or agreed to in writing, software
   distributed under the License is distributed on an "AS IS" BASIS,
   WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
   See the License for the specific language governing permissions and
   limitations under the License.
 */

 date_default_timezone_set('Europe/London');
 function validateDate($date){
     $d = DateTime::createFromFormat('Y-m-d', $date);
     return $d && $d->format('Y-m-d') === $date;
 }

 function enter_date($date_type) {
   $date = readline("Please enter the ".$date_type." date (YYYY-mm-dd) [".date("Y-m-d")."]: ")
   or $date = date("Y-m-d");
   return $date;
 }

function date_input($date_type){
  $date = enter_date($date_type);
  while (!validateDate($date)) {
    echo "ERROR entering date. Please enter a valid date in the form YYYY-mm-dd.\n";
    $date = enter_date($date_type);
  }
  return $date;
}

/*Asks users for inputs, or sets them to placeholder values, while validating date format and correctness.*/
$version_number = readline("Please enter version number:") or $version_number = 1;
while($version_number < 0){
    $version_number = readline("Please enter version number:") or $version_number = 1;
}
$db_version = readline("Please enter the Guide to Pharmacology database version used (YYYY.version)") or $db_version = date(Y).$version_number;

$db_version = "public_iuphardb_v".$db_version.".zip";

/**
Issue Date Input and Validation
**/
$date_issued = date_input("issue");

/**
Creation Date Input and Validation
**/

$date_created = date_input("creation");

/*
####################################################################
####################################################################
####################################################################
 */
$summaryfile = fopen("Data/Summary.ttl", "w") or die("Unable to open summary file!");
$versionfile = fopen("Data/Version.ttl", "w") or die("Unable to open version file!");
$ligandfile = fopen("Data/DistributionLigand.ttl", "w") or die("Unable to open ligand distribution file!");
$targetfile = fopen("Data/DistributionTarget.ttl", "w") or die("Unable to open target distribution file!");
$interactionfile = fopen("Data/DistributionInteraction.ttl", "w") or die("Unable to open interaction distribution file!");

/*Set different print values for each file*/
/*List of imports, is part of every dataset description*/
$import = "
  BASE <http://www.guidetopharmacology.org/GRAC/>
  PREFIX : <http://www.guidetopharmacology.org/GRAC/>
  PREFIX ncit: <http://ncicb.nci.nih.gov/xml/owl/EVS/Thesaurus.owl#>
  PREFIX skos: <http://www.w3.org/2004/02/skos/core#>

  PREFIX cito: <http://purl.org/spar/cito/>
  PREFIX dcat: <http://www.w3.org/ns/dcat#>
  PREFIX dctypes: <http://purl.org/dc/dcmitype/>
  PREFIX dct: <http://purl.org/dc/terms/>
  PREFIX foaf: <http://xmlns.com/foaf/0.1/>
  PREFIX freq: <http://purl.org/cld/freq/>
  PREFIX idot: <http://identifiers.org/idot/>
  PREFIX lexvo: <http://lexvo.org/ontology#>
  PREFIX pav: <http://purl.org/pav/>
  PREFIX prov: <http://www.w3.org/ns/prov#>
  PREFIX rdf: <http://www.w3.org/1999/02/22-rdf-syntax-ns#>
  PREFIX rdfs: <http://www.w3.org/2000/01/rdf-schema#>
  PREFIX schemaorg: <http://schema.org/>
  PREFIX sd: <http://www.w3.org/ns/sparql-service-description#>
  PREFIX sio: <http://semanticscience.org/resource/>
  PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>
  PREFIX void: <http://rdfs.org/ns/void/>
  PREFIX void-ext: <http://ldf.fi/void-ext#>";


/*License for Guide to Pharmacology*/
$license = "\"\"\"The Guide to PHARMACOLOGY database is licensed under the Open Data Commons Open Database License (ODbL).
				Its contents are licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported license.

For a general citation of the database please cite the article published in the Nucleic Acids Research Database Issue.

    Southan C, Sharman JL, Benson HE, Faccenda E, Pawson AJ, Alexander SPH, Buneman OP, Davenport AP, McGrath JC, Peters JA, Spedding M, Catterall WA, Fabbro D, Davies JA; NC-IUPHAR. (2016) The IUPHAR/BPS Guide to PHARMACOLOGY in 2016: towards curated quantitative interactions between 1300 protein targets and 6000 ligands. Nucl. Acids Res. 44 (Database Issue): D1054-68.

For citations of individual data please use the following guidelines:

For nomenclature and work using the concise family view pages please cite the relevant section of the Concise Guide to PHARMACOLOGY 2013/14 published in the British Journal of Pharmacology. A full list of chapters is available in the Table of Contents. For example, for GPCRs, please cite the GPCR section of the Concise Guide. Further information is also given on individual database pages.

    Alexander SPH, Kelly E, Marrion N, Peters JA, Benson HE, Faccenda E, Pawson AJ, Sharman JL, Southan C, Buneman OP, Catterall WA, Cidlowski JA, Davenport AP, Fabbro D, Fan G, McGrath JC, Spedding M, Davies JA and CGTP Collaborators. (2015) The Concise Guide to PHARMACOLOGY 2015/16. Br J Pharmacol. 172: 5729-5743.

Work using the detailed target pages and family introductions (information from IUPHAR-DB) should give the webpage address and acknowledge the NC-IUPHAR contributors who provided the information. Full citation information can be found at the bottom of each page. Example citation formats:

    Bylund DB, Bond RA, Eikenburg DC, Hieble JP, Hills R, Minneman KP, Parra S. Adrenoceptors. Last modified on 24/07/2013. Accessed on 19/08/2013. IUPHAR/BPS Guide to PHARMACOLOGY, http://www.guidetopharmacology.org/GRAC/FamilyDisplayForward?familyId=4
    Bylund DB, Bond RA, Eikenburg DC, Hieble JP, Hills R, Minneman KP, Parra S. Adrenoceptors: α1A-adrenoceptor. Last modified on 24/07/2013. Accessed on 19/08/2013. IUPHAR/BPS Guide to PHARMACOLOGY, http://www.guidetopharmacology.org/GRAC/ObjectDisplayForward?objectId=22\"\"\"@en;";

/*Summary level dataset description for Guide to Pharmacology*/

$summary = "
#Summary
<http://www.guidetopharmacology.org/GRAC/>
	rdf:type dctypes:Dataset;
	dct:title \"Guide to Pharmacology\"@en;
	dct:alternative \"IUPHAR/BPS Guide to Pharmacology\"@en;
	dct:description \"The IUPHAR/BPS Guide to PHARMACOLOGY. An expert-driven guide to pharmacological targets with quantitative information on the prescription medicines and experimental dugs that act on them. Developed as a joint initiative of the International Union of Basic and Clinical Pharmacology (IUPHAR) and the British Pharmacological Society (BPS) and is now the new home of the IUPHAR Database (IUPHAR-DB).\"@en;
	foaf:page <http://www.guidetopharmacology.org>;
	dct:publisher <http://www.guidetopharmacology.org>;
  schemaorg:logo <http://www.guidetopharmacology.org/images/GTP_favicon_lg.ico>;
	dcat:theme sio:010432; #ligand
	dcat:theme sio:010423; #target
  dcat:keyword \"Ligand\", \"Target\", \"Protein\";
	dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
	dct:rights ".$license."
  cito:citesAsAuthority <https://doi.org/10.1093/nar/gkv1037>;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
#PROVENANCE&CHANGE
  pav:hasCurrentVersion :gtp".$version_number.";
  dct:accrualPeriodicity freq:quarterly;
.";

/*Version level dataset description for Guide to Pharmacology*/

$version = "
#Version
:gtp".$version_number."
	rdf:type dctypes:Dataset;
	dct:title \"Guide to Pharmacology Version ".$version_number."\"@en;
	dct:alternative \"Guide to Pharmacology RDF Version ".$version_number."\"@en;
	dct:description \"\"\"Guide to Pharmacology is a database of pharmacological targets and the substances that act on them, driven by experts\"\"\"@en;
	dct:issued \"".$date_issued."\"^^xsd:date;
	dct:created \"".$date_created."\"^^xsd:date;
	dct:hasPart :gtp".$version_number."Ligand, :gtp".$version_number."Target, :gtp".$version_number."Interaction;
	dct:creator [foaf:page <http://www.guidetopharmacology.org>];
	dct:publisher [foaf:page<http://www.guidetopharmacology.org>];
	foaf:page <http://www.guidetopharmacology.org>;
    dcat:distribution gtpm:gtp".$version_number."Ligand;
   	dcat:distribution gtpm:gtp".$version_number."Target;
	dcat:distribution gtpm:gtp".$version_number."Interaction;
	dcat:theme sio:010432; #ligand
	dcat:theme sio:010423; #target
	dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
	dct:rights ".$license."
	dct:language <http://lexvo.org/id/iso639-3/eng>;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
#PROVENANCE&CHANGE
	dct:isVersionOf :gtp;
	pav:version \"".$version_number."\"^^xsd:string;
	dcat:source :".$db_version.";
	.";

/*Ligand Distribution level dataset description for Guide to Pharmacology*/

$ligand = "
#LIGAND Distribution
:gtp".$version_number."Ligand
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$version_number." Ligand Distribution\"@en;
	dct:alternative \"Guide to Pharmacology RDF Version ".$version_number." Ligand Distribution\"@en;
	dct:desctiption \"\"\"Guide to Pharmacology is a database of pharmacological targets and the substances that act on them, driven by experts\"\"\"@en;
	dct:issued \"".$date_issued."\"^^xsd:date;
	dct:created \"".$date_created."\"^^xsd:date;
	dct:creator [foaf:page <http://www.guidetopharmacology.org>];
	dct:publisher [foaf:page<http://www.guidetopharmacology.org>];
	foaf:page <http://www.guidetopharmacology.org>;
	dcat:theme sio:010432; #ligand
	dct:format <https://www.w3.org/ns/formats/data/N3>;
	dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
	dct:rights ".$license."
	dct:language <http://lexvo.org/id/iso639-3/eng>;
	void:vocabulary <http://identifiers.org/chembl.compound/>,<http://identifiers.org/uniprot/>, <http://purl.obolibrary.org/obo/NCBITaxon_> ;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
	idot:exampleIdentifier \"ligand2527\"^^xsd:string;
	idot:exampleResource <http://www.guidetopharmacology.com/data/ligand2527>;
#PROVENANCE&CHANGE
	pav:version \"".$version_number."\"^^xsd:string;
	dcat:source :".$db_version.";
.
";

/*Target Distribution level dataset description for Guide to Pharmacology*/

$target = "
#TARGET Distribution
:gtp".$version_number."Target
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$version_number." Target Distribution\"@en;
	dct:alternative \"Guide to Pharmacology RDF Version ".$version_number." Target Distribution\"@en;
	dct:desctiption \"\"\"Guide to Pharmacology is a database of pharmacological targets and the substances that act on them, driven by experts\"\"\"@en;
	dct:issued \"".$date_issued."\"^^xsd:date;
	dct:created \"".$date_created."\"^^xsd:date;
	dct:creator [foaf:page <http://www.guidetopharmacology.org>];
	dct:publisher [foaf:page<http://www.guidetopharmacology.org>];
	foaf:page <http://www.guidetopharmacology.org>;
	dcat:theme sio:010423; #target
	dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
	dct:format <https://www.w3.org/ns/formats/data/N3>;
	dct:rights ".$license."
	dct:language <http://lexvo.org/id/iso639-3/eng>;
	void:vocabulary <http://identifiers.org/uniprot/>, <http://purl.obolibrary.org/obo/NCBITaxon_>;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
	idot:exampleIdentifier \"target2400\"^^xsd:string;
	idot:exampleResource <http://www.guidetopharmacology.com/data/2400>;
#PROVENANCE&CHANGE
	pav:version \"".$version_number."\"^^xsd:string;
	dcat:source :".$db_version.";
.
";

/*interaction Distribution level dataset description for Guide to Pharmacology*/

$interaction = "
#Distribution
:gtp".$version_number."Interaction
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$version_number." Ligand Distribution\"@en;
	dct:alternative \"Guide to Pharmacology RDF Version ".$version_number." Ligand Distribution\"@en;
	dct:desctiption \"\"\"Guide to Pharmacology is a database of pharmacological targets and the substances that act on them, driven by experts\"\"\"@en;
	dct:issued \"".$date_issued."\"^^xsd:date;
	dct:created \"".$date_created."\"^^xsd:date;
	dct:creator [foaf:page <http://www.guidetopharmacology.org>];
	dct:publisher [foaf:page<http://www.guidetopharmacology.org>];
	foaf:page <http://www.guidetopharmacology.org>;
	dcat:theme sio:010432; #ligand
	dcat:theme sio:010423; #target
	dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
	dct:format <https://www.w3.org/ns/formats/data/N3>;
	dct:rights ".$license."
	dct:language <http://lexvo.org/id/iso639-3/eng>;
	void:vocabulary <http://www.bioassayontology.org/bao/bao_complete.owl>, <http://purl.obolibrary.org/obo/NCBITaxon_>, <http://identifiers.org/pubmed/>;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
	idot:exampleIdentifier \"interaction2833\"^^xsd:string;
	idot:exampleResource <http://www.guidetopharmacology.com/data/interaction2833>;
#PROVENANCE&CHANGE
	pav:version \"".$version_number."\"^^xsd:string;
	dcat:source :".$db_version.";
.
";


/*Write description to each file*/

fwrite($summaryfile,$import.$summary);
echo "Summary Description Generated".PHP_EOL;
fwrite($versionfile,$import.$version);
echo "Version Description Generated".PHP_EOL;
fwrite($ligandfile,$import.$ligand);
echo "Ligand Distribution Description Generated".PHP_EOL;
fwrite($targetfile,$import.$target);
echo "Target Distribution Description Generated".PHP_EOL;
fwrite($interactionfile,$import.$interaction);
echo "interaction Distribution Description Generated".PHP_EOL;
?>
