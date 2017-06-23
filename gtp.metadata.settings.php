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

define("GTP_URI_BASE", "http://www.guidetopharmacology.org/GRAC/");

#CORE Metadata Properties
define("GTP_DESCRIPTION", "dct:description \"The IUPHAR/BPS Guide to PHARMACOLOGY. An expert-driven guide to pharmacological targets with quantitative information on the prescription medicines and experimental dugs that act on them. Developed as a joint initiative of the International Union of Basic and Clinical Pharmacology (IUPHAR) and the British Pharmacological Society (BPS) and is now the new home of the IUPHAR Database (IUPHAR-DB).\"@en;");
define("GTP_CREATOR","dct:creator <http://www.guidetopharmacology.org/GRAC/ContributorListForward>;");
define("GTP_PUBLISHER", "dct:publisher <http://www.guidetopharmacology.org>;");
define("GTP_PAGE_LOGO", "foaf:page <http://www.guidetopharmacology.org>;
  schemaorg:logo <http://www.guidetopharmacology.org/images/GTP_favicon_lg.ico>;");
define("GTP_LIGAND_THEME", "dcat:keyword \"Ligand\";
	dcat:theme sio:010432; #ligand");
define("GTP_TARGET_THEME", "dcat:keyword \"Target\", \"Protein\";
	dcat:theme sio:010423; #target");
define("GTP_LICENSE_RIGHTS", "dct:license <https://opendatacommons.org/licenses/odbl/>; #data license
  dct:rights \"\"\"The Guide to PHARMACOLOGY database is licensed under the Open Data Commons Open Database License (ODbL).
				Its contents are licensed under the Creative Commons Attribution-ShareAlike 3.0 Unported license.

For a general citation of the database please cite the article published in the Nucleic Acids Research Database Issue.

    Southan C, Sharman JL, Benson HE, Faccenda E, Pawson AJ, Alexander SPH, Buneman OP, Davenport AP, McGrath JC, Peters JA, Spedding M, Catterall WA, Fabbro D, Davies JA; NC-IUPHAR. (2016) The IUPHAR/BPS Guide to PHARMACOLOGY in 2016: towards curated quantitative interactions between 1300 protein targets and 6000 ligands. Nucl. Acids Res. 44 (Database Issue): D1054-68.

For citations of individual data please use the following guidelines:

For nomenclature and work using the concise family view pages please cite the relevant section of the Concise Guide to PHARMACOLOGY 2013/14 published in the British Journal of Pharmacology. A full list of chapters is available in the Table of Contents. For example, for GPCRs, please cite the GPCR section of the Concise Guide. Further information is also given on individual database pages.

    Alexander SPH, Kelly E, Marrion N, Peters JA, Benson HE, Faccenda E, Pawson AJ, Sharman JL, Southan C, Buneman OP, Catterall WA, Cidlowski JA, Davenport AP, Fabbro D, Fan G, McGrath JC, Spedding M, Davies JA and CGTP Collaborators. (2015) The Concise Guide to PHARMACOLOGY 2015/16. Br J Pharmacol. 172: 5729-5743.

Work using the detailed target pages and family introductions (information from IUPHAR-DB) should give the webpage address and acknowledge the NC-IUPHAR contributors who provided the information. Full citation information can be found at the bottom of each page. Example citation formats:

    Bylund DB, Bond RA, Eikenburg DC, Hieble JP, Hills R, Minneman KP, Parra S. Adrenoceptors. Last modified on 24/07/2013. Accessed on 19/08/2013. IUPHAR/BPS Guide to PHARMACOLOGY, http://www.guidetopharmacology.org/GRAC/FamilyDisplayForward?familyId=4
    Bylund DB, Bond RA, Eikenburg DC, Hieble JP, Hills R, Minneman KP, Parra S. Adrenoceptors: α1A-adrenoceptor. Last modified on 24/07/2013. Accessed on 19/08/2013. IUPHAR/BPS Guide to PHARMACOLOGY, http://www.guidetopharmacology.org/GRAC/ObjectDisplayForward?objectId=22\"\"\"@en;");
define("GTP_LANGUAGE", "dct:language <http://lexvo.org/id/iso639-3/eng>;");
define("GTP_RDF_VOCABS", "void:vocabulary <http://identifiers.org/chembl.compound/>,
  <http://identifiers.org/uniprot/>,
  <http://purl.obolibrary.org/obo/NCBITaxon_> ;");
define("GTP_CITATION", "cito:citesAsAuthority <https://doi.org/10.1093/nar/gkv1037>;");

define("HCLS_PREFIXES", "BASE <".GTP_URI_BASE.">
PREFIX : <".GTP_URI_BASE.">
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
PREFIX void: <http://rdfs.org/ns/void#>
PREFIX void-ext: <http://ldf.fi/void-ext#>
PREFIX xsd: <http://www.w3.org/2001/XMLSchema#>");
?>
