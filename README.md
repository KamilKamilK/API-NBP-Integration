# NBP API

## Uruchomienie


## Polecenia konsolowe w aplikacji

Po przejściu do aplikacji zainstaluj zainstaluj composer.

- Uruchom terminal i przejdź do katalogu z aplikacją
- Uruchom polecenie `composer install`
- Po postawieniu aplikacji należy postawić serwer i zbudować bazę
- Postaw serwer `symfony serve -d`

Aplikacja w całości serwowana jest przy użyciu środowiska Docker.

- Pobierz i zainstaluj Docker for Windows
- Uruchom konsolę i przejdź do katalogu, w którym znajduje się aplikacja
- Uruchom polecenie `docker-compose up --build`
- Zbuduj bazę korzystając z komendy:
  `symfony console doctrine:database:create`
- Przeprowadź migrację `symfony console d:m:m`

## O aplikacji

Aplikacja powstała w celu pozyskiwania aktualnych kursów walut. Informacjie pozyskiwane są z bazy danych NBP.
Aby uzyskać informację lub uaktualnić już istniejące dane o kursacch należy wywołać adress url :

http://{host}/currency/A

Przykład:
http://127.0.0.1:8000/currency/A
