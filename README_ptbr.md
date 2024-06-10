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
| 02 de Janeiro | 01 de Aurorian |
| 03 de Janeiro | 02 de Aurorian | 

Para os anos bissextos, que possuem 366 dias no calendário gregoriano, acrescentamos mais 1 dia após o Achronian, chamado ***Sinchronian*** - o dia da sincronia.

| Gregoriano | Dekatriano |
| --- | --- |
| 31 de Dezembro | 28 de Nixian |
| 01 de Janeiro | `Achronian` |
| 02 de Janeiro | `Sinchronian` |
| 03 de Janeiro | 01 de Aurorian | 

## Meses

Os meses no calendário dekatriano são nomeados em ordem alfabética:

1. Aurorian
2. Borian
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

Para converter uma data gregoriana em uma data dekatriana:

```
<?php
$date = '2021-12-31'; //gregorian date
$dekatrian = new DekatrianConverter();
$dekatrianDate = $dekatrian->convert($date)->getDate(); //return '2021-13-28'
```

Para converter uma data dekatriana em uma data gregoriana:
```
<?php
$date = '2021-13-28'; //dekatrian date
$gregorian = new GregorianConverter();
$gregorianDate = $gregorian->convert($date)->getDate(); //return '2021-12-31'
```

Para retornar informações sobre a data:
```
<?php
$date = '2021-12-31'; //gregorian date
$dekatrian = new DekatrianConverter();
$dekatrianDate = $dekatrian->convert($date)->getDateInfo();

//return
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
| "wday" | Numeric representation of the day of the week | 0 (for Sunday) through 6 (for Saturday)
| "mon" | Numeric representation of a month | 1 through 13
| "year" | A full numeric representation of a year, 4 digits | 2021
| "yday" | Numeric representation of the day of the year | 0 through 365
| "weekday" | A full textual representation of the day of the week | Sunday through Saturday
| "month" | A full textual representation of a month, such as Aurorian or Hermetian | Aurorian through Nixian
