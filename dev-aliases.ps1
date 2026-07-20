<#
Dev aliases for PowerShell: when you dot-source this file it defines `composer`, `php`, and `artisan`
to run inside the `App` container via Docker Compose. This keeps your host PHP version irrelevant.

Usage (project root):
  PowerShell: `. .\dev-aliases.ps1`
  To enable permanently add to your PowerShell profile:
    Add-Content $PROFILE "`. $PWD\dev-aliases.ps1`"

Note: These aliases override the host commands in the current PowerShell session only.
#>

function composer {
    param([Parameter(ValueFromRemainingArguments=$true)] $Args)
    & docker compose exec App composer @Args
}

function php {
    param([Parameter(ValueFromRemainingArguments=$true)] $Args)
    & docker compose exec App php @Args
}

function artisan {
    param([Parameter(ValueFromRemainingArguments=$true)] $Args)
    & docker compose exec App php artisan @Args
}

Write-Host "Dev aliases loaded: composer, php, artisan -> container (App)" -ForegroundColor Green
