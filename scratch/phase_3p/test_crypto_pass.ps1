# scratch/phase_3p/test_crypto_pass.ps1
$bytes = New-Object byte[] 32
[System.Security.Cryptography.RandomNumberGenerator]::Create().GetBytes($bytes)
$migratorPassword = -join ($bytes | ForEach-Object { "{0:X2}" -f $_ })
Write-Host "Generated Hex Password Length: $($migratorPassword.Length)"
Write-Host "Sample Prefix: $($migratorPassword.Substring(0, 8))..."

