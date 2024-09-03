<?php

function imprimirTiempo($fechaHora)
{
    $zonaHorariaMexico = new DateTimeZone('America/Mexico_City');
    $fechaHoraDada = new DateTime($fechaHora, $zonaHorariaMexico);
    $fechaHoraActual = new DateTime('now', $zonaHorariaMexico);
    $intervalo = $fechaHoraDada->diff($fechaHoraActual);

    if ($intervalo->y > 0) {
        return 'hace ' . $intervalo->y . ' año' . ($intervalo->y > 1 ? 's' : '');
    }

    if ($intervalo->m > 0) {
        return 'hace ' . $intervalo->m . ' mes' . ($intervalo->m > 1 ? 'es' : '');
    }

    if ($intervalo->d > 0) {
        return 'hace ' . $intervalo->d . ' día' . ($intervalo->d > 1 ? 's' : '');
    }

    if ($intervalo->h > 0) {
        return 'hace ' . $intervalo->h . ' hora' . ($intervalo->h > 1 ? 's' : '');
    }

    if ($intervalo->i > 0) {
        return 'hace ' . $intervalo->i . ' minuto' . ($intervalo->i > 1 ? 's' : '');
    }

    if ($intervalo->s > 0) {
        return 'hace ' . $intervalo->s . ' segundo' . ($intervalo->s > 1 ? 's' : '');
    }

    return 'justo ahora';
}

function DiferenciaTiempo($fecha, $fecha2)
{
    $start_date = new DateTime($fecha);
    $since_start = $start_date->diff(new DateTime($fecha2));
    if ($since_start->y == 0) {
        if ($since_start->m == 0) {
            if ($since_start->d == 0) {
                if ($since_start->h == 0) {
                    if ($since_start->i == 0) {
                        if ($since_start->s == 0) {
                            echo $since_start->s . ' segundos';
                        } else {
                            if ($since_start->s == 1) {
                                echo $since_start->s . ' segundo';
                            } else {
                                echo $since_start->s . ' segundos';
                            }
                        }
                    } else {
                        if ($since_start->i == 1) {
                            echo $since_start->i . ' minuto';
                        } else {
                            echo $since_start->i . ' minutos';
                        }
                    }
                } else {
                    if ($since_start->h == 1) {
                        echo $since_start->h . ' hora';
                    } else {
                        echo $since_start->h . ' horas';
                    }
                }
            } else {
                if ($since_start->d == 1) {
                    echo $since_start->d . ' día';
                } else {
                    echo $since_start->d . ' días';
                }
            }
        } else {
            if ($since_start->m == 1) {
                echo $since_start->m . ' mes';
            } else {
                echo $since_start->m . ' meses';
            }
        }
    } else {
        if ($since_start->y == 1) {
            echo $since_start->y . ' año';
        } else {
            echo $since_start->y . ' años';
        }
    }
}
