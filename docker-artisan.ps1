Param(
    [Parameter(ValueFromRemainingArguments=$true)]
    [string[]]
    $Args
)

$arguments = @('compose','exec','app','php','artisan') + $Args
Start-Process -FilePath 'docker' -ArgumentList $arguments -NoNewWindow -Wait
