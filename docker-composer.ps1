Param(
    [Parameter(ValueFromRemainingArguments=$true)]
    [string[]]
    $Args
)

$arguments = @('compose','exec','app','composer') + $Args
Start-Process -FilePath 'docker' -ArgumentList $arguments -NoNewWindow -Wait
