# Event Adjudication Committee Jury Room (EAC-Jury Room)
Event Adjudication Committee - Jury Room

Project: Web-based jury portal built for the DO-Touch.NET Practice-Based Research Network's Event Adjudication Committee. This project is designed to assist investigators with determining what patient-reported events are adverse events by consensus of review committee members. The raw dataset is parsed from a CSV file generated by a separate survey generator and moved into a MySQL database. The committee members log into a web-based portal where each event identified as potentially adverse can be reviewed and voted upon until the committee reaches a consensus.

# Cite
Geoffroey-Allen Franklin, Jane Coe Johnson. (2016). Event Adjudication Committee Jury Room (EAC-Jury Room) [Computer software]. (Version 1.0.0) Kirksville, MO: Still Research Institute at A.T. Still University. Zenodo.

# Contributions
#### Instrumentation
- Jane C. Johnson, MA [@jcjohnsonmo](https://github.com/jcjohnsonmo)

#### Code
- Geoffroey-Allen S. Franklin, MBA, AdeC, MCP [@frgeof](https://github.com/frgeof)
- Jane C. Johnson, MA [@jcjohnsonmo](https://github.com/jcjohnsonmo)

#### Alpha and Beta Test
- William J. Brooks, DO
- Brian F. Degenhardt, DO
- Geoffroey-Allen S. Franklin, MBA, AdeC, MCP [@frgeof](https://github.com/frgeof)
- Jane C. Johnson, MA [@jcjohnsonmo](https://github.com/jcjohnsonmo)
- Lisa Norman, BS, PMP

#### Support Contact
- Geoffroey-Allen S. Franklin, MBA, AdeC, MCP [@frgeof](https://github.com/frgeof)
  - gfranklin@atsu.edu
  - (o) 480.265.8091
  - http://www.atsu.edu/research/

# Change Log
#### Created Date
- 2016-Oct-20

#### Milestone Dates
- 2016-Aug-26 - Version 0.1.
- 2017-Oct-20 - Version 0.9.alpha. Moved to Github repo.
- 2017-Dec-14 - Version 1.0.beta.
- 2018-Jun-25 - Version 1.0.
- 2018-Jun-28 - First use in a study.

# Directory structure
Directory | Purpose
----------|--------
  ../EAC Portal/ | top level directory, contains the main executables.
  ../code/ | contains code and log file for the push2portal system.
  ../html/ | contains the html code for the web portal. (Put this folder on the webserver.)
  ../output_data/ | (optional) directory where files generated by main executables will be stored. 
  ../input_data/ | directory where files to be analysed are located.
  ../sql/ | directory where the MySql reverse engineer scripts are stored. 

# Dependencies / Built-upon / Testing Environment
- Linux version: tested with Debian GNU/Linux 9 (stretch) Kernel 4.9.0-5-amd64
- Apache version: tested with 2.4.25
- MySQL version: tested with Community Server (SPL) 5.7.15-log & MySQL Community Server (GPL) 5.7.20
- PHP version: tested with 5.6.2nts & PHP 7.0.30-0
- [PHPMailer](https://github.com/PHPMailer) version: tested with 5.2.16 & 6.0.3
- reCAPTCHA v2

