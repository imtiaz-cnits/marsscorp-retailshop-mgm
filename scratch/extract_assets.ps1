Add-Type -AssemblyName System.IO.Compression.FileSystem
$zipPath = Resolve-Path "..\marss-corp.zip"
$zip = [System.IO.Compression.ZipFile]::OpenRead($zipPath)

foreach ($entry in $zip.Entries) {
    if ($entry.FullName -match 'assets/(css|js)/') {
        # Check if it corresponds to public/backend/assets/
        $relPath = $entry.FullName
        # Replace back-end with backend
        $relPath = $relPath -replace '^[^/]+/public/back-end/', 'public/backend/'
        $relPath = $relPath -replace '^public/back-end/', 'public/backend/'
        
        $destFile = Join-Path (Get-Location) $relPath
        $destDir = Split-Path $destFile
        if (-not (Test-Path $destDir)) {
            New-Item -ItemType Directory -Path $destDir -Force | Out-Null
        }
        if (-not $entry.FullName.EndsWith('/')) {
            Write-Host "Extracting: $($entry.FullName) -> $destFile"
            [System.IO.Compression.ZipFileExtensions]::ExtractToFile($entry, $destFile, $true)
        }
    }
}
$zip.Dispose()
Write-Host "Extraction complete!"
