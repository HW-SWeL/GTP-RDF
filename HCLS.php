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

include 'gtp.metadata.settings.php';

date_default_timezone_set('Europe/London');
$db_publish_date = date("Y-m-d");

function checkDataDir() {
  if (!is_dir('Data')) {
    mkdir('Data', 0777, true);
  }
}

function validateDate($date){
  $d = DateTime::createFromFormat('Y-m-d', $date);
  return $d && $d->format('Y-m-d') === $date;
}

function enter_date($date_type) {
  global $db_publish_date;
  $date = readline("Please enter the ".$date_type." date (YYYY-mm-dd) [".$db_publish_date."]: ") or $date = $db_publish_date;
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

function get_db_parameters() {
  $host = readline("Database host [localhost]: ") or $host = "localhost";
  $port = readline("Database port [5432]: ") or $port = "5432";
  $dbname = readline("Database name [Guide2Pharma]: ") or $dbname = "Guide2Pharma";
  $user = readline("Database user [postgres]: ") or $user = "postgres";
  $password = readline("Database password: ");
  return "host=".$host." port=".$port." dbname=".$dbname." user=".$user." password=".$password;
}

/* Connect to Guide 2 Pharmacology database to retrieve some default values */
if (extension_loaded(pdo_pgsql)) {
  $dbconnection = pg_connect(get_db_parameters());
  if($dbconnection) {
    echo "Connected to Guide to Pharmacology database...";
    $query = 'SELECT version_number, publish_date from version';
    $result = pg_query($dbconnection, $query) or error('Query failed: ' . pg_last_error());
    $row = pg_fetch_assoc($result);
    $db_version_number = $row['version_number'];
    $db_publish_date = $row['publish_date'];
    echo "metadata extracted.\n";
  } else {
    echo "Unable to connect to the database. Using dummy default values.\n";
    $db_version_number = date('Y.m');
    $db_publish_date = date('Y-m-d');
  }
  pg_close($dbconnection);
} else {
  do {
    echo "WARNING: Unable to connect to Guide to Pharmacology database.\n";
    $response = readline("Do you wish to proceed with dummy values? [y|N] ") or $response = "n";
  } while (!(strcasecmp($response, "y") == 0 or strcasecmp($response, "n") == 0));
  if (strcasecmp($response, "y") == 0) {
    $db_version_number = date('Y.m');
    $db_publish_date = date('Y-m-d');
  } else {
    die();
  }
}

/*Asks users for inputs, or sets them to placeholder values, while validating date format and correctness.*/
$version_number = readline("Please enter the Guide to Pharmacology database version used [".$db_version_number."]: ") or $version_number = $db_version_number;
$rdf_version_number = readline("Please enter version number for the generated RDF [".$db_version_number."]: ") or $rdf_version_number = $db_version_number;
$db_source_file = "http://www.guidetopharmacology.org/DATA/public_iuphardb_v".$version_number.".zip";

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
checkDataDir();
$summaryfile = fopen("Data/gtp.ttl", "w") or die("Unable to open summary file!");
$versionfile = fopen("Data/gtp".$version_number.".ttl", "w") or die("Unable to open version file!");

$GTP_DATES = "dct:issued \"".$date_issued."\"^^xsd:date;
	dct:created \"".$date_created."\"^^xsd:date;";

$GTP_PREFIX = "idot:preferredPrefix \"gtp\"^^xsd:string;";
$GTP_RDF_DATA_DOWNLOAD = "http://www.guidetopharmacology.org/DATA/rdf/".$version_number."/";

/*Summary level dataset description for Guide to Pharmacology*/

$summary = "
#Summary
<".GTP_URI_BASE.">
	rdf:type dctypes:Dataset;
	dct:title \"Guide to Pharmacology\"@en;
	dct:alternative \"IUPHAR/BPS Guide to Pharmacology\"@en;
  ".GTP_DESCRIPTION."
  ".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_LIGAND_THEME."
  ".GTP_TARGET_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_CITATION."
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
	dct:alternative \"IUPHAR/BPS Guide to Pharmacology Version ".$version_number."\"@en;
  ".GTP_DESCRIPTION."
  ".$GTP_DATES."
	".GTP_CREATOR."
	".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_LIGAND_THEME."
  ".GTP_TARGET_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_LANGUAGE."
  ".GTP_CITATION."
  dct:hasPart :gtp".$version_number."Ligand, :gtp".$version_number."Target, :gtp".$version_number."Interaction;
#IDENTIFIERS
	idot:preferredPrefix \"gtp\"^^xsd:string;
#PROVENANCE&CHANGE
  pav:version \"".$version_number."\"^^xsd:string;
	dct:isVersionOf <".GTP_URI_BASE.">;
  #pav:previousVersion ???
#AVAILABILITY/DISTRIBUTIONS
  dcat:distribution :gtp".$version_number.".postgres;
	.
:gtp".$version_number."Ligand dcat:distribution :gtp".$rdf_version_number."Ligand.n3 .
:gtp".$version_number."Target dcat:distribution :gtp".$rdf_version_number."Target.n3 .
:gtp".$version_number."Interaction dcat:distribution :gtp".$rdf_version_number."Interaction.n3 .
  ";

/* Postgres data dump distribution description */
$postgres = "
#Postgres Distribution
:gtp".$version_number.".postgres
  rdf:type dctypes:Dataset, dcat:Distribution;
  dct:title \"Guide to Pharmacology Version ".$version_number." PostgreSQL Database Distribution\"@en;
  dct:alternative \"IUPHAR/BPS Guide to Pharmacology Version ".$version_number." PostgreSQL Database Distribution\"@en;
  ".GTP_DESCRIPTION."
  ".$GTP_DATES."
	".GTP_CREATOR."
	".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_LIGAND_THEME."
  ".GTP_TARGET_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_LANGUAGE."
  ".GTP_CITATION."
#IDENTIFIERS
#PROVENANCE&CHANGE
  pav:version \"".$version_number."\"^^xsd:string;
  #pav:previousVersion ???
  pav:createdWith <https://www.postgresql.org/>;
#AVAILABILITY/DISTRIBUTIONS
  dct:format \"application/sql\";
  dcat:downloadURL <".$db_source_file.">;
  .
";

//TODO: Combine the n3 distributions into one and have a single description for them
/*Ligand Distribution level dataset description for Guide to Pharmacology*/

$ligand = "
#LIGAND n3 Distribution
:gtp".$rdf_version_number."Ligand.n3
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$rdf_version_number." Ligand Distribution\"@en;
	dct:alternative \"IUPHAR/BPS Guide to Pharmacology RDF Version ".$rdf_version_number." Ligand Distribution\"@en;
  ".GTP_DESCRIPTION."
  ".$GTP_DATES."
  ".GTP_CREATOR."
	".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_LIGAND_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_LANGUAGE."
  ".GTP_RDF_VOCABS."
  ".GTP_CITATION."
#IDENTIFIERS
  ".$GTP_PREFIX."
  idot:identifierPattern \"ligand\\\\d+\"^^xsd:string;
  void:uriRegexPattern \"".GTP_URI_BASE."ligand\\\\d+\";
	idot:exampleIdentifier \"ligand2527\"^^xsd:string;
	void:exampleResource <".GTP_URI_BASE."ligand2527>;
#PROVENANCE&CHANGE
	pav:version \"".$rdf_version_number."\"^^xsd:string;
	dcat:source <".$db_source_file.">;
  pav:createdWith <https://github.com/HW-SWeL/GTP-RDF>;
#AVAILABILITY/DISTRIBUTIONS
  dct:format <https://www.w3.org/ns/formats/data/N3>;
  void:accessURL <".$GTP_RDF_DATA_DOWNLOAD.">;
  void:downloadURL <".$GTP_RDF_DATA_DOWNLOAD."ligand".$rdf_version_number.".n3>;
  void:dataDump <".$GTP_RDF_DATA_DOWNLOAD."ligand".$rdf_version_number.".n3>;
#STATISTICS
.
";

/*Target Distribution level dataset description for Guide to Pharmacology*/

$target = "
#TARGET n3 Distribution
:gtp".$rdf_version_number."Target.n3
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$rdf_version_number." Target Distribution\"@en;
	dct:alternative \"Guide to Pharmacology RDF Version ".$rdf_version_number." Target Distribution\"@en;
  ".GTP_DESCRIPTION."
  ".$GTP_DATES."
  ".GTP_CREATOR."
	".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_TARGET_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_LANGUAGE."
  ".GTP_RDF_VOCABS."
  ".GTP_CITATION."
#IDENTIFIERS
".$GTP_PREFIX."
  idot:identifierPattern \"target\\\\d+\"^^xsd:string;
  void:uriRegexPattern \"".GTP_URI_BASE."target\\\\d+\";
	idot:exampleIdentifier \"target2400\"^^xsd:string;
	void:exampleResource <".GTP_URI_BASE."target2400>;
#PROVENANCE&CHANGE
	pav:version \"".$rdf_version_number."\"^^xsd:string;
	dcat:source <".$db_source_file.">;
  pav:createdWith <https://github.com/HW-SWeL/GTP-RDF>;
#AVAILABILITY/DISTRIBUTIONS
  dct:format <https://www.w3.org/ns/formats/data/N3>;
  void:accessURL <".$GTP_RDF_DATA_DOWNLOAD.">;
  void:downloadURL <".$GTP_RDF_DATA_DOWNLOAD."target".$rdf_version_number.".n3>;
  void:dataDump <".$GTP_RDF_DATA_DOWNLOAD."target".$rdf_version_number.".n3>;
#STATISTICS
.
";

/*interaction Distribution level dataset description for Guide to Pharmacology*/

$interaction = "
#Interaction n3 Distribution
:gtp".$rdf_version_number."Interaction.n3
	rdf:type dctypes:Dataset, dcat:Distribution, void:Dataset;
	dct:title \"Guide to Pharmacology Version ".$rdf_version_number." Interactions Distribution\"@en;
	dct:alternative \"IUPHAR/BPS Guide to Pharmacology RDF Version ".$rdf_version_number." Interactions Distribution\"@en;
  ".GTP_DESCRIPTION."
  ".$GTP_DATES."
  ".GTP_CREATOR."
	".GTP_PUBLISHER."
  ".GTP_PAGE_LOGO."
  ".GTP_LIGAND_THEME."
  ".GTP_TARGET_THEME."
  ".GTP_LICENSE_RIGHTS."
  ".GTP_LANGUAGE."
  ".GTP_RDF_VOCABS."
  ".GTP_CITATION."
#IDENTIFIERS
  ".$GTP_PREFIX."
  idot:identifierPattern \"interaction\\\\d+\"^^xsd:string;
  void:uriRegexPattern \"".GTP_URI_BASE."interaction\\\\d+\";
	idot:exampleIdentifier \"interaction2833\"^^xsd:string;
	void:exampleResource <".GTP_URI_BASE."interaction2833>;
  #PROVENANCE&CHANGE
  	pav:version \"".$rdf_version_number."\"^^xsd:string;
  	dcat:source <".$db_source_file.">;
    pav:createdWith <https://github.com/HW-SWeL/GTP-RDF>;
  #AVAILABILITY/DISTRIBUTIONS
    dct:format <https://www.w3.org/ns/formats/data/N3>;
    void:accessURL <".$GTP_RDF_DATA_DOWNLOAD.">;
    void:downloadURL <".$GTP_RDF_DATA_DOWNLOAD."interaction".$rdf_version_number.".n3>;
    void:dataDump <".$GTP_RDF_DATA_DOWNLOAD."interaction".$rdf_version_number.".n3>;
  #STATISTICS
.
";


/*Write description to each file*/

fwrite($summaryfile,HCLS_PREFIXES.$summary);
echo "Summary Description Generated".PHP_EOL;
fwrite($versionfile,HCLS_PREFIXES.$version.$postgres.$ligand.$target.$interaction);
echo "Version Description Generated".PHP_EOL;
?>
