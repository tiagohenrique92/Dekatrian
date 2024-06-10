# Calendário Dekatriano

[English](https://github.com/tiagohenrique92/Dekatrian/blob/main/README.md)

## O que é?

O calendário dekatriano é um calendário pensado para organizar melhor a distribuição dos dias e meses do ano.

## Como?

Basicamente, o calendário dekatriano é dividido em 13 meses de 28 dias, com 4 semanas de 7 dias, totalizando 364 dias.

Para manter a compatibilidade com o calendário gregoriano, que possui 365 dias, acrescentamos 1 dia no calendário dekatriano, entre o último e o primeiro dia do ano. Este dia é chamado ***Achronian*** - o dia fora do tempo.

| Gregoriano | Dekatriano |
| --- | --- |
| 31 de Dezembro | 28 de Nixian |
| 01 de Janeiro | `Achronian`  |
| 02 de Janeiro | 01 de Auroran |
| 03 de Janeiro | 02 de Auroran | 

Para os anos bissextos, que possuem 366 dias no calendário gregoriano, acrescentamos 1 dia após o Achronian, chamado ***Sinchronian*** - o dia da sincronia.

| Gregoriano | Dekatriano |
| --- | --- |
| 31 de Dezembro | 28 de Nixian |
| 01 de Janeiro | `Achronian` |
| 02 de Janeiro | `Sinchronian` |
| 03 de Janeiro | 01 de Auroran | 

## Meses

Os meses no calendário dekatriano são nomeados em ordem alfabética:

1. Auroran
2. Borean
3. Coronian
4. Driadan
5. Electran
6. Faian
7. Gaian
8. Hermetian
9. Irisian
10. Kaosian
11. Lunan
12. Maian
13. Nixian

Não existe um mês começado com a letra "J" porque os nomes foram definidos em latim, onde a letra "J" não está presente.

## Como usar

Para converter uma data gregoriana numa data dekatriana:

```
<?php
$date = '2021-12-31'; //gregorian date
$dekatrianDate = DekatrianDateFactory::createFromGregorian($date)->getDate(); //return '2021-13-28'
```

Para converter uma data dekatriana numa data gregoriana:
```
<?php
$date = '2021-13-28'; //dekatrian date
$gregorianDate = GregorianDateFactory::createFromDekatrian($date)->getDate(); //return '2021-12-31'
```

Para retornar informações sobre a data:
```
<?php
$date = '2021-12-31'; //gregorian date
$dekatrianDate = DekatrianDateFactory::createFromGregorian($date)->getDateInfo();

// return
Array
(
    [mday] => 28
    [wday] => 6
    [mon] => 13
    [year] => 2021
    [yday] => 363
    [weekday] => Friday
    [month] => Nixian
)
```

| Key | Description | Example returned values |
| --- | --- | --- |
| "mday" | Numeric representation of the day of the month | 1 to 28
| "wday" | Numeric representation of the day of the week | <ul><li>-2 to 6 (Achronian, Sinchronian and other days in leap years)</li><li>-1 to 6 (Achronian and other days in non-leap years)</li></ul>
| "mon" | Numeric representation of a month | 1 through 13
| "year" | A full numeric representation of a year, 4 digits | 2021
| "yday" | Numeric representation of the day of the year | <ul><li>-2 to 363 in leap years</li><li>-1 to 363 in non-leap years</li></ul>
| "weekday" | A full textual representation of the day of the week | Achronian, Sinchronian, Sunday through Saturday
| "month" | A full textual representation of a month, such as Auroran or Hermetian | Auroran through Nixian, or Out Of Time in Achronian and Sinchronian
