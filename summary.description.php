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
	".GTP_PREFERRED_PREFIX."
#PROVENANCE&CHANGE
  pav:hasCurrentVersion :gtp".$version_number.";
  dct:accrualPeriodicity freq:quarterly;
.";
?>
