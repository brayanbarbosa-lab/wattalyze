<<<<<<< HEAD
<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains thousands of video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
=======
<div align="center">

# ⚡ WATTALYZE

### A Ponte Inteligente para Monitoramento de Energia IoT

[![Laravel](https://img.shields.io/badge/Laravel-10.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)](https://laravel.com)
[![PHP](https://img.shields.io/badge/PHP-8.1+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![Vite](https://img.shields.io/badge/Vite-5.0-646CFF?style=for-the-badge&logo=vite&logoColor=white)](https://vitejs.dev)
[![InfluxDB](https://img.shields.io/badge/InfluxDB-Cloud-22ADF6?style=for-the-badge&logo=influxdb&logoColor=white)](https://www.influxdata.com/)
[![ESP32](https://img.shields.io/badge/ESP32-Firmware-E7352C?style=for-the-badge&logo=espressif&logoColor=white)](https://github.com/brayanbarbosa-lab/wattalyze-firmware)

> Revolucione seu gerenciamento de energia. Conecte, monitore e otimize seus equipamentos com análise em tempo real.

</div>

---

## 📋 Sobre o Projeto

O **WATTALYZE** é uma solução completa de monitoramento de energia IoT — do hardware ao software. Desenvolvemos tanto o **equipamento físico** quanto a **plataforma web**, permitindo conectar dispositivos inteligentes, analisar consumo em tempo real e gerar relatórios detalhados.

> 🎓 Projeto desenvolvido como **TCC do 3º ano** do curso de Desenvolvimento de Sistemas na **ETEC**.

### ✨ Principais Funcionalidades

- ⚡ **Monitoramento em tempo real** — acompanhe o consumo de energia de cada dispositivo
- 🌡️ **Monitoramento ambiental** — temperatura e umidade dos ambientes
- 📊 **Dashboard analítico** — visualize gráficos e métricas detalhadas
- 🔔 **Sistema de alertas** — receba notificações sobre anomalias e consumo elevado
- 📱 **Gestão de dispositivos IoT** — cadastre e gerencie seus equipamentos
- 🌍 **Gestão de ambientes** — organize dispositivos por cômodos e locais
- 📄 **Geração de relatórios** — exporte relatórios em PDF e Excel
- 🔒 **API segura** — endpoints protegidos com autenticação por token
- 🔌 **Controle remoto** *(em desenvolvimento)* — desligue equipamentos diretamente pela plataforma

---

## 🏗️ Arquitetura do Sistema

```
Sensor (SCT-013 / DHT11)
        ↓
      ESP32
        ↓ Wi-Fi (a cada 10s)
   InfluxDB Cloud  ←→  API Laravel (MySQL)
                            ↓
                     Plataforma Web
```

Os dispositivos ESP32 enviam dados diretamente ao **InfluxDB Cloud**. A plataforma Laravel consome esses dados via API e os exibe no dashboard, além de gerenciar usuários, dispositivos, alertas e relatórios em um banco **MySQL**.

---

## 🔧 Hardware

> O equipamento foi **100% desenvolvido pela equipe Wattalyze**, com case próprio e firmware personalizado para ESP32.

### 📦 Módulo 1 — Medidor de Consumo de Energia

| Componente | Função |
|---|---|
| **ESP32** | Microcontrolador principal com Wi-Fi integrado |
| **SCT-013-000** | Sensor de corrente não invasivo (até 100A) |
| **Conversor 100-240V → 5V** | Alimentação direta da rede elétrica |

### 📦 Módulo 2 — Monitor Ambiental

| Componente | Função |
|---|---|
| **ESP32** | Microcontrolador principal com Wi-Fi integrado |
| **DHT11** | Sensor de temperatura e umidade |


> ⚠️ Os dispositivos físicos funcionam vinculados a uma conta cadastrada na plataforma. Para testar com um dispositivo real, entre em contato com a equipe.

### 🔮 Roadmap de Hardware

- [ ] Controle remoto de equipamentos via relé pela plataforma web
- [ ] Módulo com display integrado no sensor de corrente
- [ ] Versão com bateria para ambientes sem tomada

➡️ Firmware disponível em: **[wattalyze-firmware](https://github.com/brayanbarbosa-lab/wattalyze-firmware)**

---

## 🚀 Tecnologias Utilizadas

| Tecnologia | Versão | Função |
|---|---|---|
| **Laravel** | 10.x | Framework backend |
| **PHP** | 8.1+ | Linguagem principal |
| **MySQL** | 8.0 | Banco de dados relacional |
| **InfluxDB Cloud** | — | Banco de dados de séries temporais (IoT) |
| **Vite** | 5.0 | Bundler de assets |
| **Node.js** | 18+ | Ambiente JS |
| **Composer** | 2.x | Gerenciador de pacotes PHP |
| **ESP32** | — | Microcontrolador IoT |

---

## 🛠️ Como Rodar o Projeto

### Pré-requisitos

- [PHP 8.1+](https://www.php.net/) (recomendado via [Laragon](https://laragon.org/))
- [Composer](https://getcomposer.org/)
- [Node.js](https://nodejs.org/)
- [MySQL](https://www.mysql.com/)

### 📦 Instalação

```bash
# 1. Clone o repositório
git clone https://github.com/brayanbarbosa-lab/wattalyze.git

# 2. Entre na pasta do projeto
cd wattalyze

# 3. Instale as dependências PHP
composer install

# 4. Instale as dependências JS
npm install

# 5. Copie o arquivo de ambiente
cp .env.example .env

# 6. Gere a chave da aplicação
php artisan key:generate
```

### ⚙️ Configuração

Edite o arquivo `.env`:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wattalyze
DB_USERNAME=root
DB_PASSWORD=

API_SECRET=seu_token_secreto

# InfluxDB Cloud
INFLUXDB_URL=https://us-east-1-1.aws.cloud2.influxdata.com
INFLUXDB_TOKEN=seu_token_influxdb
INFLUXDB_ORG=wattalyze
INFLUXDB_BUCKET=Iot
```

### 🗄️ Banco de Dados

```bash
php artisan migrate:fresh --seed
```

### ▶️ Rodando o Projeto

```bash
# Terminal 1 — Backend
php artisan serve

# Terminal 2 — Frontend
npm run dev
```

Acesse: **http://localhost:8000** 🎉

### 🔑 Acesso

Crie sua própria conta diretamente pela plataforma. Para testar com um dispositivo físico real, entre em contato com a equipe.

---

## 📡 API

A API segue o padrão REST com autenticação via **Bearer Token**.

```
Authorization: Bearer seu_token_secreto
```

| Método | Endpoint | Descrição |
|---|---|---|
| `GET` | `/api/v1/devices` | Listar dispositivos |
| `GET` | `/api/v1/alerts` | Listar alertas |
| `GET` | `/api/v1/dashboard/overview` | Visão geral |
| `GET` | `/api/v1/dashboard/consumption` | Dados de consumo |
| `GET` | `/api/v1/energy-data` | Dados de energia |
| `POST` | `/api/energy-data` | Enviar dados IoT |
| `GET` | `/api/v1/reports` | Listar relatórios |

---

## 🗺️ Repositórios

| Repositório | Descrição |
|---|---|
| **[wattalyze](https://github.com/brayanbarbosa-lab/wattalyze)** | API e plataforma web (este repositório) |
| **[wattalyze-firmware](https://github.com/brayanbarbosa-lab/wattalyze-firmware)** | Código-fonte ESP32 |

---

## 👨‍💻 Equipe

Desenvolvido por alunos do 3º ano de Desenvolvimento de Sistemas da **ETEC**:

| Nome |
|---|
| **Brayan Barbosa Dos Santos** |
| **Samuel Matos Gabriel** |
| **Bianca Da Silva Tavares** |
| **Gabriel Carlos Barbosa** |
| **Miguel Neves Duarte** |

---

## 📄 Licença

MIT License — veja o arquivo [LICENSE](LICENSE) para mais detalhes.

---

<div align="center">

Feito com ⚡ pela equipe **WATTALYZE** — ETEC 2024

</div>
>>>>>>> b39e4424dddc98daa8b22408dfd5d9cb83ef3820
