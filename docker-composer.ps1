Param(
    [Parameter(ValueFromRemainingArguments=$true)]
    [string[]]
    $Args
)

$arguments = @('compose','exec','App','composer') + $Args
Start-Process -FilePath 'docker' -ArgumentList $arguments -NoNewWindow -Wait
