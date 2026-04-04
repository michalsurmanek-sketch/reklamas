<?php
require_once 'config.php';

if (!isLoggedIn()) {
    header('Location: login.php');
    exit;
}

$username = $_SESSION['reklamas_username'] ?? 'admin';
?>
<!doctype html>
<html lang="cs">
<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width,initial-scale=1" />
  <title>Reklamas Core | Přihlášky a admin</title>
  <meta name="theme-color" content="#facc15" />
  <meta name="description" content="Reklamas Core – veřejná přihláška a interní přehled zájemců a klientů." />

  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    html { scroll-behavior: smooth; }
    body { font-family: 'Montserrat', sans-serif; }
    .tab-btn.active { background:#facc15; color:#111; }
    .role-btn.active { background:#facc15; border-color:#facc15; }
    .hidden-section { display:none; }
  </style>
</head>
<body class="min-h-screen bg-gradient-to-b from-yellow-50 via-white to-white text-black">

  <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-10">
    <div class="rounded-[28px] border border-black/10 bg-white shadow-sm overflow-hidden">

      <div class="bg-black text-white px-6 py-5">
        <div class="flex flex-wrap items-center justify-between gap-4">
          <div>
            <div class="text-xs uppercase tracking-[0.25em] text-yellow-300">Reklamas Core</div>
            <h1 class="text-2xl md:text-4xl font-extrabold mt-1">Mozek pro klienty, řidiče, cyklisty a chodce</h1>
            <p class="text-white/70 mt-2 max-w-3xl">První HTML verze: veřejný nábor + interní třídění zájemců + jednoduché párování podle města a typu spolupráce.</p>
          </div>

          <div class="flex flex-wrap items-center gap-2">
            <span class="rounded-xl bg-white/10 text-white px-3 py-1.5 text-sm font-semibold">
              Přihlášen: <?php echo htmlspecialchars($username, ENT_QUOTES, 'UTF-8'); ?>
            </span>
            <a href="logout.php" class="rounded-xl bg-yellow-400 text-black px-3 py-1.5 text-sm font-bold hover:bg-yellow-300 transition">
              Odhlásit
            </a>
          </div>
        </div>
      </div>

      <div class="p-5 md:p-6">
        <div class="grid grid-cols-2 rounded-2xl bg-yellow-100 p-1 h-auto max-w-xl">
          <button id="tab-verejna" class="tab-btn active rounded-2xl py-3 font-bold transition">Veřejná sekce</button>
          <button id="tab-admin" class="tab-btn rounded-2xl py-3 font-bold transition">Interní sekce</button>
        </div>

        <section id="section-verejna" class="mt-6">
          <div class="grid lg:grid-cols-[1.05fr,0.95fr] gap-6">

            <div class="rounded-3xl border border-black/10 shadow-sm bg-white">
              <div class="p-6 border-b border-black/10">
                <h2 class="text-2xl font-extrabold">Přihláška do systému Reklamas</h2>
                <p class="mt-2 text-black/65">Jeden chytrý formulář pro lidi i firmy. Po odeslání se vše uloží do interní sekce.</p>
              </div>

              <div class="p-6">
                <form id="leadForm" class="space-y-5">
                  <div class="grid sm:grid-cols-4 gap-2">
                    <button type="button" class="role-btn active rounded-2xl border border-yellow-400 p-4 text-left transition" data-role="ridic">
                      <div class="text-xl mb-2">🚗</div>
                      <div class="font-bold">Řidič</div>
                    </button>
                    <button type="button" class="role-btn rounded-2xl border border-black/10 p-4 text-left transition hover:bg-yellow-50" data-role="cyklista">
                      <div class="text-xl mb-2">🚴</div>
                      <div class="font-bold">Cyklista</div>
                    </button>
                    <button type="button" class="role-btn rounded-2xl border border-black/10 p-4 text-left transition hover:bg-yellow-50" data-role="chodec">
                      <div class="text-xl mb-2">🚶</div>
                      <div class="font-bold">Chodec</div>
                    </button>
                    <button type="button" class="role-btn rounded-2xl border border-black/10 p-4 text-left transition hover:bg-yellow-50" data-role="klient">
                      <div class="text-xl mb-2">🏢</div>
                      <div class="font-bold">Klient</div>
                    </button>
                  </div>

                  <input type="hidden" id="role" value="ridic">

                  <div id="fields-osoba" class="grid md:grid-cols-2 gap-4">
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Jméno a příjmení</label>
                      <input id="name" type="text" placeholder="Vaše jméno" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Telefon</label>
                      <input id="phone" type="text" placeholder="+420..." class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Město</label>
                      <input id="city" type="text" placeholder="Brno" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label id="vehicleLabel" class="block text-sm font-semibold">Typ auta</label>
                      <input id="vehicle" type="text" placeholder="Např. Škoda Octavia" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2 md:col-span-2">
                      <label id="kmLabel" class="block text-sm font-semibold">Aktivita</label>
                      <input id="km" type="text" placeholder="Např. 60 km/den" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                  </div>

                  <div id="fields-klient" class="grid md:grid-cols-2 gap-4 hidden-section">
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Název firmy</label>
                      <input id="company" type="text" placeholder="Např. Kavárna U Náměstí" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Telefon</label>
                      <input id="clientPhone" type="text" placeholder="+420..." class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Město kampaně</label>
                      <input id="clientCity" type="text" placeholder="Brno" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2">
                      <label class="block text-sm font-semibold">Typ reklamy</label>
                      <input id="adType" type="text" placeholder="Auto / kolo / chodec / trička" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                    <div class="space-y-2 md:col-span-2">
                      <label class="block text-sm font-semibold">Rozpočet</label>
                      <input id="budget" type="text" placeholder="Např. 12 000 Kč" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                    </div>
                  </div>

                  <div class="space-y-2">
                    <label class="block text-sm font-semibold">Poznámka</label>
                    <textarea id="note" placeholder="Doplňující informace" class="w-full min-h-[110px] rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black"></textarea>
                  </div>

                  <div class="flex flex-wrap gap-3">
                    <button type="submit" class="rounded-2xl bg-yellow-400 px-5 py-3 font-bold text-black transition hover:bg-yellow-300">Odeslat přihlášku</button>
                    <button type="button" class="rounded-2xl border border-black/10 px-5 py-3 font-semibold transition hover:bg-yellow-50">Jak to funguje</button>
                  </div>
                </form>
              </div>
            </div>

            <div class="space-y-6">
              <div class="rounded-3xl border border-black/10 shadow-sm bg-yellow-50 p-6">
                <h3 class="text-xl font-extrabold">Co se stane po odeslání</h3>
                <div class="mt-4 space-y-4 text-sm">
                  <div class="rounded-2xl border border-black/10 bg-white p-4"><span class="font-bold">1.</span> Zájemce dostane vlastní ID profilu.</div>
                  <div class="rounded-2xl border border-black/10 bg-white p-4"><span class="font-bold">2.</span> Automaticky se uloží do interního přehledu.</div>
                  <div class="rounded-2xl border border-black/10 bg-white p-4"><span class="font-bold">3.</span> Ty ho můžeš filtrovat, kontaktovat a přiřadit ke kampani.</div>
                </div>
              </div>

              <div class="rounded-3xl border border-black/10 shadow-sm bg-white p-6">
                <h3 class="text-xl font-extrabold">Potvrzení odeslání</h3>
                <p class="mt-2 text-black/60">Ukázka toho, co uvidí člověk po registraci.</p>
                <div id="submitMessage" class="mt-4 rounded-2xl border border-dashed border-black/15 p-5 text-sm text-black/60">
                  Po testovacím odeslání se tady zobrazí potvrzení s ID profilu.
                </div>
              </div>
            </div>
          </div>
        </section>

        <section id="section-admin" class="mt-6 hidden-section">
          <div class="grid xl:grid-cols-[300px,1fr] gap-6">

            <div class="space-y-6">
              <div class="rounded-2xl border border-black/10 shadow-sm p-5 flex items-center gap-4">
                <div class="h-11 w-11 rounded-2xl bg-yellow-100 flex items-center justify-center text-xl">👥</div>
                <div>
                  <div class="text-sm text-black/60">Všichni zájemci</div>
                  <div id="stat-total" class="text-2xl font-extrabold">0</div>
                </div>
              </div>

              <div class="rounded-2xl border border-black/10 shadow-sm p-5 flex items-center gap-4">
                <div class="h-11 w-11 rounded-2xl bg-yellow-100 flex items-center justify-center text-xl">🕓</div>
                <div>
                  <div class="text-sm text-black/60">Noví</div>
                  <div id="stat-new" class="text-2xl font-extrabold">0</div>
                </div>
              </div>

              <div class="rounded-2xl border border-black/10 shadow-sm p-5 flex items-center gap-4">
                <div class="h-11 w-11 rounded-2xl bg-yellow-100 flex items-center justify-center text-xl">✅</div>
                <div>
                  <div class="text-sm text-black/60">Aktivní</div>
                  <div id="stat-active" class="text-2xl font-extrabold">0</div>
                </div>
              </div>

              <div class="rounded-2xl border border-black/10 shadow-sm p-5 flex items-center gap-4">
                <div class="h-11 w-11 rounded-2xl bg-yellow-100 flex items-center justify-center text-xl">💼</div>
                <div>
                  <div class="text-sm text-black/60">Klienti</div>
                  <div id="stat-clients" class="text-2xl font-extrabold">0</div>
                </div>
              </div>

              <div class="rounded-3xl border border-black/10 shadow-sm bg-white p-6">
                <h3 class="text-xl font-extrabold">Filtry</h3>

                <div class="mt-4 space-y-4">
                  <div class="space-y-2">
                    <label class="block text-sm font-semibold">Hledat</label>
                    <input id="searchInput" type="text" placeholder="Jméno, město, ID..." class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black" />
                  </div>

                  <div class="space-y-2">
                    <label class="block text-sm font-semibold">Město</label>
                    <select id="cityFilter" class="w-full rounded-2xl border borderblack/10 px-4 py-3 outline-none focus:border-black">
                      <option value="vse">Všechna města</option>
                    </select>
                  </div>

                  <div class="space-y-2">
                    <label class="block text-sm font-semibold">Role</label>
                    <select id="roleFilter" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black">
                      <option value="vse">Všechny role</option>
                      <option value="ridic">Řidič</option>
                      <option value="cyklista">Cyklista</option>
                      <option value="chodec">Chodec</option>
                      <option value="klient">Klient</option>
                    </select>
                  </div>

                  <div class="space-y-2">
                    <label class="block text-sm font-semibold">Stav</label>
                    <select id="statusFilter" class="w-full rounded-2xl border border-black/10 px-4 py-3 outline-none focus:border-black">
                      <option value="vse">Všechny stavy</option>
                      <option value="novy">Nový</option>
                      <option value="kontaktovan">Kontaktovaný</option>
                      <option value="aktivni">Aktivní</option>
                      <option value="zamitnut">Zamítnutý</option>
                    </select>
                  </div>
                </div>
              </div>

              <div class="rounded-3xl border border-black/10 shadow-sm bg-black text-white p-6">
                <h3 class="text-xl font-extrabold">Chytré párování</h3>
                <div id="matchingSuggestion" class="mt-4 rounded-2xl bg-white/10 p-4 text-sm text-white/90">
                  Zatím žádné automatické párování.
                </div>
              </div>
            </div>

            <div class="space-y-4">
              <div class="flex flex-wrap items-center justify-between gap-3">
                <div>
                  <h2 class="text-2xl font-extrabold">Přehled zájemců a klientů</h2>
                  <p class="text-black/65">Tady třídíš, hledáš a rozhoduješ, kdo je vhodný pro spolupráci.</p>
                </div>
                <button class="rounded-2xl bg-yellow-400 px-5 py-3 font-bold text-black transition hover:bg-yellow-300">Vytvořit kampaň</button>
              </div>

              <div id="leadsContainer" class="grid gap-4"></div>
            </div>
          </div>
        </section>
      </div>
    </div>
  </div>

  <script>
    const initialLeads = [
      {
        id: 'RK-2451',
        role: 'ridic',
        name: 'Petr Novák',
        city: 'Brno',
        phone: '+420 777 111 222',
        vehicle: 'Škoda Octavia',
        km: '80 km/den',
        status: 'novy',
        note: 'Jezdí denně centrum + sídliště.'
      },
      {
        id: 'RK-2452',
        role: 'cyklista',
        name: 'Tomáš Blaha',
        city: 'Uherské Hradiště',
        phone: '+420 777 333 444',
        vehicle: 'Městské kolo',
        km: '25 km/den',
        status: 'kontaktovan',
        note: 'Ochotný na eventy a promo.'
      },
      {
        id: 'RK-2453',
        role: 'klient',
        name: 'Kavárna U Náměstí',
        city: 'Zlín',
        phone: '+420 777 555 666',
        vehicle: 'Chce auto + chodec',
        km: 'Rozpočet 12 000 Kč',
        status: 'aktivni',
        note: 'Zájem o lokální promo a QR měření.'
      },
      {
        id: 'RK-2454',
        role: 'chodec',
        name: 'Lucie Horáková',
        city: 'Brno',
        phone: '+420 777 888 999',
        vehicle: 'Promo tabule',
        km: '4 hod/den',
        status: 'novy',
        note: 'Vhodná na pěší promo v centru.'
      }
    ];

    const roleLabels = {
      ridic: 'Řidič',
      cyklista: 'Cyklista',
      chodec: 'Chodec',
      klient: 'Klient'
    };

    const statusLabels = {
      novy: 'Nový',
      kontaktovan: 'Kontaktovaný',
      aktivni: 'Aktivní',
      zamitnut: 'Zamítnutý'
    };

    let leads = [...initialLeads];
    let currentRole = 'ridic';

    const tabVerejna = document.getElementById('tab-verejna');
    const tabAdmin = document.getElementById('tab-admin');
    const sectionVerejna = document.getElementById('section-verejna');
    const sectionAdmin = document.getElementById('section-admin');
    const roleButtons = document.querySelectorAll('.role-btn');
    const roleInput = document.getElementById('role');
    const fieldsOsoba = document.getElementById('fields-osoba');
    const fieldsKlient = document.getElementById('fields-klient');
    const vehicleLabel = document.getElementById('vehicleLabel');
    const kmLabel = document.getElementById('kmLabel');
    const leadsContainer = document.getElementById('leadsContainer');
    const submitMessage = document.getElementById('submitMessage');

    const searchInput = document.getElementById('searchInput');
    const cityFilter = document.getElementById('cityFilter');
    const roleFilter = document.getElementById('roleFilter');
    const statusFilter = document.getElementById('statusFilter');

    function switchTab(tab) {
      const isVerejna = tab === 'verejna';
      tabVerejna.classList.toggle('active', isVerejna);
      tabAdmin.classList.toggle('active', !isVerejna);
      sectionVerejna.classList.toggle('hidden-section', !isVerejna);
      sectionAdmin.classList.toggle('hidden-section', isVerejna);
    }

    tabVerejna.addEventListener('click', () => switchTab('verejna'));
    tabAdmin.addEventListener('click', () => switchTab('admin'));

    function updateRoleUI(role) {
      currentRole = role;
      roleInput.value = role;

      roleButtons.forEach(btn => {
        btn.classList.toggle('active', btn.dataset.role === role);
      });

      if (role === 'klient') {
        fieldsOsoba.classList.add('hidden-section');
        fieldsKlient.classList.remove('hidden-section');
      } else {
        fieldsOsoba.classList.remove('hidden-section');
        fieldsKlient.classList.add('hidden-section');

        if (role === 'ridic') {
          vehicleLabel.textContent = 'Typ auta';
          kmLabel.textContent = 'Aktivita';
          document.getElementById('vehicle').placeholder = 'Např. Škoda Octavia';
          document.getElementById('km').placeholder = 'Např. 60 km/den';
        } else if (role === 'cyklista') {
          vehicleLabel.textContent = 'Typ kola';
          kmLabel.textContent = 'Aktivita';
          document.getElementById('vehicle').placeholder = 'Např. Městské kolo';
          document.getElementById('km').placeholder = 'Např. 25 km/den';
        } else {
          vehicleLabel.textContent = 'Typ promo nosiče';
          kmLabel.textContent = 'Dostupnost';
          document.getElementById('vehicle').placeholder = 'Např. Promo tabule';
          document.getElementById('km').placeholder = 'Např. 4 hod/den';
        }
      }
    }

    roleButtons.forEach(btn => {
      btn.addEventListener('click', () => updateRoleUI(btn.dataset.role));
    });

    function getFilteredLeads() {
      const search = searchInput.value.trim().toLowerCase();
      const city = cityFilter.value;
      const role = roleFilter.value;
      const status = statusFilter.value;

      return leads.filter(item => {
        const haystack = [item.name, item.city, item.id, item.phone, item.vehicle, item.note].join(' ').toLowerCase();
        const matchesSearch = !search || haystack.includes(search);
        const matchesCity = city === 'vse' || item.city === city;
        const matchesRole = role === 'vse' || item.role === role;
        const matchesStatus = status === 'vse' || item.status === status;
        return matchesSearch && matchesCity && matchesRole && matchesStatus;
      });
    }

    function renderStats() {
      document.getElementById('stat-total').textContent = leads.length;
      document.getElementById('stat-new').textContent = leads.filter(x => x.status === 'novy').length;
      document.getElementById('stat-active').textContent = leads.filter(x => x.status === 'aktivni').length;
      document.getElementById('stat-clients').textContent = leads.filter(x => x.role === 'klient').length;
    }

    function renderCityFilter() {
      const current = cityFilter.value;
      const cities = [...new Set(leads.map(x => x.city))].sort((a, b) => a.localeCompare(b, 'cs'));
      cityFilter.innerHTML = '<option value="vse">Všechna města</option>';
      cities.forEach(city => {
        const option = document.createElement('option');
        option.value = city;
        option.textContent = city;
        cityFilter.appendChild(option);
      });
      cityFilter.value = cities.includes(current) ? current : 'vse';
    }

    function renderMatchingSuggestion() {
      const clients = leads.filter(x => x.role === 'klient');
      let bestText = 'Zatím žádné automatické párování. Jakmile přibude klient a lidé ve stejném městě, systém nabídne match.';

      for (const client of clients) {
        const partners = leads.filter(x => x.city === client.city && x.role !== 'klient' && x.status !== 'zamitnut').length;
        if (partners > 0) {
          bestText = `Máte klienta v ${client.city} a ${partners} vhodné lidi pro nasazení.`;
          break;
        }
      }

      document.getElementById('matchingSuggestion').textContent = bestText;
    }

    function createStatusBadge(status) {
      const colorMap = {
        novy: 'bg-black text-white',
        kontaktovan: 'bg-sky-100 text-sky-900',
        aktivni: 'bg-green-100 text-green-900',
        zamitnut: 'bg-red-100 text-red-900'
      };
      return `<span class="rounded-xl px-3 py-1.5 text-sm font-bold ${colorMap[status] || 'bg-black text-white'}">${statusLabels[status] || status}</span>`;
    }

    function renderLeads() {
      const filtered = getFilteredLeads();
      leadsContainer.innerHTML = '';

      if (!filtered.length) {
        leadsContainer.innerHTML = `
          <div class="rounded-3xl border border-dashed border-black/15 p-10 text-center text-black/55">
            Nic nebylo nalezeno pro aktuální filtry.
          </div>
        `;
        return;
      }

      filtered.forEach(item => {
        const iconMap = {
          ridic: '🚗',
          cyklista: '🚴',
          chodec: '🚶',
          klient: '🏢'
        };

        const card = document.createElement('div');
        card.className = 'rounded-3xl border border-black/10 shadow-sm hover:shadow-md transition bg-white';
        card.innerHTML = `
          <div class="p-6">
            <div class="flex flex-wrap items-start justify-between gap-3">
              <div class="flex items-start gap-4">
                <div class="h-12 w-12 rounded-2xl bg-yellow-100 flex items-center justify-center shrink-0 text-xl">
                  ${iconMap[item.role] || '👤'}
                </div>
                <div>
                  <div class="flex flex-wrap items-center gap-2">
                    <div class="text-lg font-extrabold">${item.name}</div>
                    <span class="rounded-xl bg-black/5 px-3 py-1 text-sm font-semibold">${item.id}</span>
                  </div>
                  <div class="mt-1 text-sm text-black/65">${roleLabels[item.role] || item.role}</div>
                </div>
              </div>
              ${createStatusBadge(item.status)}
            </div>

            <div class="mt-5 grid md:grid-cols-2 gap-3 text-sm">
              <div class="rounded-2xl border border-black/10 p-3 bg-white">
                <div class="text-black/55">Město</div>
                <div class="font-semibold mt-1">📍 ${item.city}</div>
              </div>
              <div class="rounded-2xl border border-black/10 p-3 bg-white">
                <div class="text-black/55">Telefon</div>
                <div class="font-semibold mt-1">📞 ${item.phone}</div>
              </div>
              <div class="rounded-2xl border border-black/10 p-3 bg-white">
                <div class="text-black/55">Typ / vozidlo / formát</div>
                <div class="font-semibold mt-1">${item.vehicle}</div>
              </div>
              <div class="rounded-2xl border border-black/10 p-3 bg-white">
                <div class="text-black/55">Aktivita / rozpočet</div>
                <div class="font-semibold mt-1">${item.km}</div>
              </div>
            </div>

            <div class="mt-4 rounded-2xl bg-yellow-50 border border-yellow-200 p-3 text-sm">
              <span class="font-semibold">Poznámka:</span> ${item.note}
            </div>

            <div class="mt-5 flex flex-wrap gap-2">
              <button class="action-btn rounded-2xl bg-yellow-400 px-4 py-2.5 font-bold text-black hover:bg-yellow-300" data-id="${item.id}" data-status="aktivni">Schválit</button>
              <button class="action-btn rounded-2xl border border-black/10 px-4 py-2.5 font-semibold hover:bg-yellow-50" data-id="${item.id}" data-status="kontaktovan">Kontaktovat</button>
              <button class="action-btn rounded-2xl border border-black/10 px-4 py-2.5 font-semibold hover:bg-yellow-50" data-id="${item.id}" data-status="zamitnut">Odmítnout</button>
              <button class="rounded-2xl border border-black/10 px-4 py-2.5 font-semibold hover:bg-yellow-50">Přiřadit ke kampani</button>
            </div>
          </div>
        `;
        leadsContainer.appendChild(card);
      });

      document.querySelectorAll('.action-btn').forEach(btn => {
        btn.addEventListener('click', () => {
          const id = btn.dataset.id;
          const nextStatus = btn.dataset.status;
          leads = leads.map(item => item.id === id ? { ...item, status: nextStatus } : item);
          renderAll();
        });
      });
    }

    function renderAll() {
      renderStats();
      renderCityFilter();
      renderMatchingSuggestion();
      renderLeads();
    }

    document.getElementById('leadForm').addEventListener('submit', function(e) {
      e.preventDefault();

      const role = roleInput.value;
      const isClient = role === 'klient';
      const nextId = `RK-${2450 + leads.length + 1}`;

      const newItem = {
        id: nextId,
        role,
        name: isClient ? (document.getElementById('company').value || 'Neuvedeno') : (document.getElementById('name').value || 'Neuvedeno'),
        city: isClient ? (document.getElementById('clientCity').value || 'Neuvedeno') : (document.getElementById('city').value || 'Neuvedeno'),
        phone: isClient ? (document.getElementById('clientPhone').value || 'Neuvedeno') : (document.getElementById('phone').value || 'Neuvedeno'),
        vehicle: isClient ? (document.getElementById('adType').value || 'Neuvedeno') : (document.getElementById('vehicle').value || 'Neuvedeno'),
        km: isClient ? `Rozpočet ${document.getElementById('budget').value || 'neuveden'}` : (document.getElementById('km').value || 'Neuvedeno'),
        status: 'novy',
        note: document.getElementById('note').value || 'Bez poznámky'
      };

      leads.unshift(newItem);

      submitMessage.className = 'mt-4 rounded-2xl border border-green-200 bg-green-50 p-5 text-sm text-black/70';
      submitMessage.innerHTML = `
        <div class="font-bold text-lg text-black">Hotovo, přihláška je uložená.</div>
        <div class="mt-2">Vaše ID profilu je <span class="font-extrabold">${nextId}</span>. Ozveme se podle města, typu spolupráce a dostupnosti kampaně.</div>
      `;

      this.reset();
      updateRoleUI(currentRole);
      renderAll();
      switchTab('admin');
    });

    [searchInput, cityFilter, roleFilter, statusFilter].forEach(el => {
      el.addEventListener('input', renderLeads);
      el.addEventListener('change', renderLeads);
    });

    updateRoleUI('ridic');
    renderAll();
  </script>
</body>
</html>
