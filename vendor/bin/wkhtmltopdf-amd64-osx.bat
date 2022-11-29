@ECHO OFF
setlocal DISABLEDELAYEDEXPANSION
SET BIN_TARGET=%~dp0/../profburial/wkhtmltopdf-binaries-osx/bin/wkhtmltopdf-amd64-osx
php "%BIN_TARGET%" %*
