@REM /* This programme is property of and copyright to the A. T. Still Research Institute.
@REM Project:           Event Adjudication Committee (EAC) Portal
@REM Instrumentation:   Jane Johnson, MA
@REM Code by:           Geoffroey-Allen S. Franklin, MBA, BS, AAS, AdeC, MCP
@REM Created:           2016-Oct-20
@REM Change Log:        2016-Oct-20 - Version 1.0 release.

@ECHO OFF
set curr_dir=%cd%
setlocal enabledelayedexpansion
chdir "%curr_dir%\code"
ECHO Start of command: !time!

ECHO Delete old data: !time!.
@REM =========================================>>> un@REM next line before public release
del /F /Q "%curr_dir%\code\logfile.txt"
@REM =========================================>>> @REM next line after Beta phase
@REM del /F /Q "%curr_dir%\output_data\*.*"

ECHO Gathering input files.
del /F /Q "%curr_dir%\input_data\filelist.txt"
dir /A-D /B /OD /S "..\input_data\OMTAdverseEvent*.csv" >> "%curr_dir%\input_data\filelist.txt

ECHO Processing Data: !time!.
@REM server config issue
@REM php "%curr_dir%\code\push2portal.php"
C:\Tools\php-5.6.22nts\php.exe "%curr_dir%\code\phase-check.php"

chdir /d "%curr_dir%"

ECHO End of commands: !time!.
