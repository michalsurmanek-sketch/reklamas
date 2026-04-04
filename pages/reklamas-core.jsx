import React, { useMemo, useState } from "react";
import { Card, CardContent, CardHeader, CardTitle, CardDescription } from "@/components/ui/card";
import { Button } from "@/components/ui/button";
import { Input } from "@/components/ui/input";
import { Label } from "@/components/ui/label";
import { Badge } from "@/components/ui/badge";
import { Tabs, TabsContent, TabsList, TabsTrigger } from "@/components/ui/tabs";
import { Select, SelectContent, SelectItem, SelectTrigger, SelectValue } from "@/components/ui/select";
import { Textarea } from "@/components/ui/textarea";
import { Search, UserPlus, Car, Bike, Footprints, Building2, Phone, MapPin, Filter, CheckCircle2, Clock3, XCircle, Briefcase, Users } from "lucide-react";
import { motion } from "framer-motion";

const initialLeads = [
  {
    id: "RK-2451",
    role: "ridic",
    name: "Petr Novák",
    city: "Brno",
    phone: "+420 777 111 222",
    vehicle: "Škoda Octavia",
    km: "80 km/den",
    status: "novy",
    rating: 4,
    note: "Jezdí denně centrum + sídliště.",
  },
  {
    id: "RK-2452",
    role: "cyklista",
    name: "Tomáš Blaha",
    city: "Uherské Hradiště",
    phone: "+420 777 333 444",
    vehicle: "Městské kolo",
    km: "25 km/den",
    status: "kontaktovan",
    rating: 5,
    note: "Ochotný na eventy a promo.",
  },
  {
    id: "RK-2453",
    role: "klient",
    name: "Kavárna U Náměstí",
    city: "Zlín",
    phone: "+420 777 555 666",
    vehicle: "Chce auto + chodec",
    km: "Rozpočet 12 000 Kč",
    status: "aktivni",
    rating: 5,
    note: "Zájem o lokální promo a QR měření.",
  },
  {
    id: "RK-2454",
    role: "chodec",
    name: "Lucie Horáková",
    city: "Brno",
    phone: "+420 777 888 999",
    vehicle: "Promo tabule",
    km: "4 hod/den",
    status: "novy",
    rating: 3,
    note: "Vhodná na pěší promo v centru.",
  },
];

const statusMap = {
  novy: { label: "Nový", icon: Clock3 },
  kontaktovan: { label: "Kontaktovaný", icon: Phone },
  aktivni: { label: "Aktivní", icon: CheckCircle2 },
  zamitnut: { label: "Zamítnutý", icon: XCircle },
};

const roleMap = {
  ridic: { label: "Řidič", icon: Car },
  cyklista: { label: "Cyklista", icon: Bike },
  chodec: { label: "Chodec", icon: Footprints },
  klient: { label: "Klient", icon: Building2 },
};

function Stat({ icon: Icon, label, value }) {
  return (
    <Card className="rounded-2xl border-black/10 shadow-sm">
      <CardContent className="p-5 flex items-center gap-4">
        <div className="h-11 w-11 rounded-2xl bg-yellow-100 flex items-center justify-center">
          <Icon className="h-5 w-5" />
        </div>
        <div>
          <div className="text-sm text-black/60">{label}</div>
          <div className="text-2xl font-extrabold">{value}</div>
        </div>
      </CardContent>
    </Card>
  );
}

function LeadCard({ item, onStatus }) {
  const RoleIcon = roleMap[item.role]?.icon || Users;
  const StatusIcon = statusMap[item.status]?.icon || Clock3;

  return (
    <motion.div initial={{ opacity: 0, y: 12 }} animate={{ opacity: 1, y: 0 }}>
      <Card className="rounded-3xl border-black/10 shadow-sm hover:shadow-md transition">
        <CardContent className="p-6">
          <div className="flex flex-wrap items-start justify-between gap-3">
            <div className="flex items-start gap-4">
              <div className="h-12 w-12 rounded-2xl bg-yellow-100 flex items-center justify-center shrink-0">
                <RoleIcon className="h-5 w-5" />
              </div>
              <div>
                <div className="flex flex-wrap items-center gap-2">
                  <div className="text-lg font-extrabold">{item.name}</div>
                  <Badge variant="secondary" className="rounded-xl">{item.id}</Badge>
                </div>
                <div className="mt-1 text-sm text-black/65">{roleMap[item.role]?.label}</div>
              </div>
            </div>
            <Badge className="rounded-xl bg-black text-white hover:bg-black flex items-center gap-1">
              <StatusIcon className="h-3.5 w-3.5" />
              {statusMap[item.status]?.label}
            </Badge>
          </div>

          <div className="mt-5 grid md:grid-cols-2 gap-3 text-sm">
            <div className="rounded-2xl border border-black/10 p-3 bg-white">
              <div className="text-black/55">Město</div>
              <div className="font-semibold flex items-center gap-2 mt-1"><MapPin className="h-4 w-4" />{item.city}</div>
            </div>
            <div className="rounded-2xl border border-black/10 p-3 bg-white">
              <div className="text-black/55">Telefon</div>
              <div className="font-semibold flex items-center gap-2 mt-1"><Phone className="h-4 w-4" />{item.phone}</div>
            </div>
            <div className="rounded-2xl border border-black/10 p-3 bg-white">
              <div className="text-black/55">Typ / vozidlo / formát</div>
              <div className="font-semibold mt-1">{item.vehicle}</div>
            </div>
            <div className="rounded-2xl border border-black/10 p-3 bg-white">
              <div className="text-black/55">Aktivita / rozpočet</div>
              <div className="font-semibold mt-1">{item.km}</div>
            </div>
          </div>

          <div className="mt-4 rounded-2xl bg-yellow-50 border border-yellow-200 p-3 text-sm">
            <span className="font-semibold">Poznámka:</span> {item.note}
          </div>

          <div className="mt-5 flex flex-wrap gap-2">
            <Button className="rounded-2xl bg-yellow-400 text-black hover:bg-yellow-300" onClick={() => onStatus(item.id, "aktivni")}>Schválit</Button>
            <Button variant="outline" className="rounded-2xl" onClick={() => onStatus(item.id, "kontaktovan")}>Kontaktovat</Button>
            <Button variant="outline" className="rounded-2xl" onClick={() => onStatus(item.id, "zamitnut")}>Odmítnout</Button>
            <Button variant="outline" className="rounded-2xl">Přiřadit ke kampani</Button>
          </div>
        </CardContent>
      </Card>
    </motion.div>
  );
}

export default function ReklamasCoreMVP() {
  const [leads, setLeads] = useState(initialLeads);
  const [role, setRole] = useState("ridic");
  const [search, setSearch] = useState("");
  const [cityFilter, setCityFilter] = useState("vse");
  const [statusFilter, setStatusFilter] = useState("vse");
  const [roleFilter, setRoleFilter] = useState("vse");
  const [form, setForm] = useState({
    name: "",
    phone: "",
    city: "",
    vehicle: "",
    km: "",
    note: "",
    company: "",
    budget: "",
    adType: "",
  });
  const [submittedId, setSubmittedId] = useState("");

  const stats = useMemo(() => ({
    total: leads.length,
    newOnes: leads.filter((x) => x.status === "novy").length,
    active: leads.filter((x) => x.status === "aktivni").length,
    clients: leads.filter((x) => x.role === "klient").length,
  }), [leads]);

  const filtered = useMemo(() => {
    return leads.filter((item) => {
      const matchesSearch = [item.name, item.city, item.id, item.phone, item.vehicle, item.note]
        .join(" ")
        .toLowerCase()
        .includes(search.toLowerCase());
      const matchesCity = cityFilter === "vse" ? true : item.city === cityFilter;
      const matchesStatus = statusFilter === "vse" ? true : item.status === statusFilter;
      const matchesRole = roleFilter === "vse" ? true : item.role === roleFilter;
      return matchesSearch && matchesCity && matchesStatus && matchesRole;
    });
  }, [leads, search, cityFilter, statusFilter, roleFilter]);

  const matchingSuggestion = useMemo(() => {
    const brnoClient = leads.find((x) => x.role === "klient" && x.city === "Brno");
    const brnoPartners = leads.filter((x) => x.city === "Brno" && x.role !== "klient").length;
    if (brnoClient) return `Máte klienta v Brně a ${brnoPartners} vhodné lidi pro nasazení.`;
    return "Zatím žádné automatické párování. Jakmile přibude klient a lidé ve stejném městě, systém nabídne match.";
  }, [leads]);

  const updateStatus = (id, nextStatus) => {
    setLeads((prev) => prev.map((item) => (item.id === id ? { ...item, status: nextStatus } : item)));
  };

  const handleSubmit = (e) => {
    e.preventDefault();
    const nextId = `RK-${2450 + leads.length + 1}`;
    const isClient = role === "klient";

    const newItem = {
      id: nextId,
      role,
      name: isClient ? form.company || form.name : form.name,
      city: form.city,
      phone: form.phone,
      vehicle: isClient ? form.adType || "Neuvedeno" : form.vehicle || "Neuvedeno",
      km: isClient ? `Rozpočet ${form.budget || "neuveden"}` : form.km || "Neuvedeno",
      status: "novy",
      rating: 0,
      note: form.note || "Bez poznámky",
    };

    setLeads((prev) => [newItem, ...prev]);
    setSubmittedId(nextId);
    setForm({ name: "", phone: "", city: "", vehicle: "", km: "", note: "", company: "", budget: "", adType: "" });
  };

  const cities = Array.from(new Set(leads.map((x) => x.city)));

  return (
    <div className="min-h-screen bg-gradient-to-b from-yellow-50 via-white to-white text-black">
      <div className="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 md:py-10">
        <div className="rounded-[28px] border border-black/10 bg-white shadow-sm overflow-hidden">
          <div className="bg-black text-white px-6 py-5">
            <div className="flex flex-wrap items-center justify-between gap-4">
              <div>
                <div className="text-xs uppercase tracking-[0.25em] text-yellow-300">Reklamas Core</div>
                <h1 className="text-2xl md:text-4xl font-extrabold mt-1">Mozek pro klienty, řidiče, cyklisty a chodce</h1>
                <p className="text-white/70 mt-2 max-w-3xl">První MVP verze: veřejný nábor + interní třídění zájemců + chytré párování podle města a typu spolupráce.</p>
              </div>
              <div className="flex flex-wrap gap-2">
                <Badge className="rounded-xl bg-yellow-400 text-black hover:bg-yellow-400">MVP připraveno</Badge>
                <Badge variant="secondary" className="rounded-xl">Reklamas.cz styl</Badge>
              </div>
            </div>
          </div>

          <div className="p-5 md:p-6">
            <Tabs defaultValue="verejna" className="w-full">
              <TabsList className="grid grid-cols-2 rounded-2xl bg-yellow-100 p-1 h-auto">
                <TabsTrigger value="verejna" className="rounded-2xl py-3">Veřejná sekce</TabsTrigger>
                <TabsTrigger value="admin" className="rounded-2xl py-3">Interní sekce</TabsTrigger>
              </TabsList>

              <TabsContent value="verejna" className="mt-6">
                <div className="grid lg:grid-cols-[1.05fr,0.95fr] gap-6">
                  <Card className="rounded-3xl border-black/10 shadow-sm">
                    <CardHeader>
                      <CardTitle className="text-2xl">Přihláška do systému Reklamas</CardTitle>
                      <CardDescription>Jeden chytrý formulář pro lidi i firmy. Po odeslání se vše uloží do interní sekce.</CardDescription>
                    </CardHeader>
                    <CardContent>
                      <form onSubmit={handleSubmit} className="space-y-5">
                        <div className="grid sm:grid-cols-4 gap-2">
                          {Object.entries(roleMap).map(([key, item]) => {
                            const Icon = item.icon;
                            const active = role === key;
                            return (
                              <button
                                key={key}
                                type="button"
                                onClick={() => setRole(key)}
                                className={`rounded-2xl border p-4 text-left transition ${active ? "bg-yellow-400 border-yellow-400" : "bg-white border-black/10 hover:bg-yellow-50"}`}
                              >
                                <Icon className="h-5 w-5 mb-2" />
                                <div className="font-bold">{item.label}</div>
                              </button>
                            );
                          })}
                        </div>

                        <div className="grid md:grid-cols-2 gap-4">
                          {role === "klient" ? (
                            <>
                              <div className="space-y-2">
                                <Label>Název firmy</Label>
                                <Input value={form.company} onChange={(e) => setForm({ ...form, company: e.target.value })} placeholder="Např. Kavárna U Náměstí" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>Telefon</Label>
                                <Input value={form.phone} onChange={(e) => setForm({ ...form, phone: e.target.value })} placeholder="+420..." className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>Město kampaně</Label>
                                <Input value={form.city} onChange={(e) => setForm({ ...form, city: e.target.value })} placeholder="Brno" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>Typ reklamy</Label>
                                <Input value={form.adType} onChange={(e) => setForm({ ...form, adType: e.target.value })} placeholder="Auto / kolo / chodec / trička" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2 md:col-span-2">
                                <Label>Rozpočet</Label>
                                <Input value={form.budget} onChange={(e) => setForm({ ...form, budget: e.target.value })} placeholder="Např. 12 000 Kč" className="rounded-2xl" />
                              </div>
                            </>
                          ) : (
                            <>
                              <div className="space-y-2">
                                <Label>Jméno a příjmení</Label>
                                <Input value={form.name} onChange={(e) => setForm({ ...form, name: e.target.value })} placeholder="Vaše jméno" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>Telefon</Label>
                                <Input value={form.phone} onChange={(e) => setForm({ ...form, phone: e.target.value })} placeholder="+420..." className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>Město</Label>
                                <Input value={form.city} onChange={(e) => setForm({ ...form, city: e.target.value })} placeholder="Brno" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2">
                                <Label>{role === "ridic" ? "Typ auta" : role === "cyklista" ? "Typ kola" : "Typ promo nosiče"}</Label>
                                <Input value={form.vehicle} onChange={(e) => setForm({ ...form, vehicle: e.target.value })} placeholder="Např. Škoda Octavia" className="rounded-2xl" />
                              </div>
                              <div className="space-y-2 md:col-span-2">
                                <Label>{role === "chodec" ? "Dostupnost" : "Aktivita"}</Label>
                                <Input value={form.km} onChange={(e) => setForm({ ...form, km: e.target.value })} placeholder={role === "chodec" ? "Např. 4 hod/den" : "Např. 60 km/den"} className="rounded-2xl" />
                              </div>
                            </>
                          )}

                          <div className="space-y-2 md:col-span-2">
                            <Label>Poznámka</Label>
                            <Textarea value={form.note} onChange={(e) => setForm({ ...form, note: e.target.value })} placeholder="Doplňující informace" className="rounded-2xl min-h-[110px]" />
                          </div>
                        </div>

                        <div className="flex flex-wrap gap-3">
                          <Button type="submit" className="rounded-2xl bg-yellow-400 text-black hover:bg-yellow-300">
                            <UserPlus className="h-4 w-4 mr-2" />
                            Odeslat přihlášku
                          </Button>
                          <Button type="button" variant="outline" className="rounded-2xl">Jak to funguje</Button>
                        </div>
                      </form>
                    </CardContent>
                  </Card>

                  <div className="space-y-6">
                    <Card className="rounded-3xl border-black/10 shadow-sm bg-yellow-50">
                      <CardHeader>
                        <CardTitle className="text-xl">Co se stane po odeslání</CardTitle>
                      </CardHeader>
                      <CardContent className="space-y-4 text-sm">
                        <div className="rounded-2xl border border-black/10 bg-white p-4"><span className="font-bold">1.</span> Zájemce dostane vlastní ID profilu.</div>
                        <div className="rounded-2xl border border-black/10 bg-white p-4"><span className="font-bold">2.</span> Automaticky se uloží do interního přehledu.</div>
                        <div className="rounded-2xl border border-black/10 bg-white p-4"><span className="font-bold">3.</span> Ty ho můžeš filtrovat, kontaktovat a přiřadit ke kampani.</div>
                      </CardContent>
                    </Card>

                    <Card className="rounded-3xl border-black/10 shadow-sm">
                      <CardHeader>
                        <CardTitle className="text-xl">Potvrzení odeslání</CardTitle>
                        <CardDescription>Ukázka toho, co uvidí člověk po registraci.</CardDescription>
                      </CardHeader>
                      <CardContent>
                        {submittedId ? (
                          <div className="rounded-2xl border border-green-200 bg-green-50 p-5">
                            <div className="font-bold text-lg">Hotovo, přihláška je uložená.</div>
                            <div className="mt-2 text-sm text-black/70">Vaše ID profilu je <span className="font-extrabold">{submittedId}</span>. Ozveme se podle města, typu spolupráce a dostupnosti kampaně.</div>
                          </div>
                        ) : (
                          <div className="rounded-2xl border border-dashed border-black/15 p-5 text-sm text-black/60">
                            Po testovacím odeslání se tady zobrazí potvrzení s ID profilu.
                          </div>
                        )}
                      </CardContent>
                    </Card>
                  </div>
                </div>
              </TabsContent>

              <TabsContent value="admin" className="mt-6">
                <div className="grid xl:grid-cols-[300px,1fr] gap-6">
                  <div className="space-y-6">
                    <Stat icon={Users} label="Všichni zájemci" value={stats.total} />
                    <Stat icon={Clock3} label="Noví" value={stats.newOnes} />
                    <Stat icon={CheckCircle2} label="Aktivní" value={stats.active} />
                    <Stat icon={Briefcase} label="Klienti" value={stats.clients} />

                    <Card className="rounded-3xl border-black/10 shadow-sm">
                      <CardHeader>
                        <CardTitle className="text-xl flex items-center gap-2"><Filter className="h-5 w-5" />Filtry</CardTitle>
                      </CardHeader>
                      <CardContent className="space-y-4">
                        <div className="space-y-2">
                          <Label>Hledat</Label>
                          <div className="relative">
                            <Search className="h-4 w-4 absolute left-3 top-1/2 -translate-y-1/2 text-black/45" />
                            <Input value={search} onChange={(e) => setSearch(e.target.value)} placeholder="Jméno, město, ID..." className="rounded-2xl pl-9" />
                          </div>
                        </div>

                        <div className="space-y-2">
                          <Label>Město</Label>
                          <Select value={cityFilter} onValueChange={setCityFilter}>
                            <SelectTrigger className="rounded-2xl"><SelectValue placeholder="Všechna města" /></SelectTrigger>
                            <SelectContent>
                              <SelectItem value="vse">Všechna města</SelectItem>
                              {cities.map((city) => <SelectItem key={city} value={city}>{city}</SelectItem>)}
                            </SelectContent>
                          </Select>
                        </div>

                        <div className="space-y-2">
                          <Label>Role</Label>
                          <Select value={roleFilter} onValueChange={setRoleFilter}>
                            <SelectTrigger className="rounded-2xl"><SelectValue placeholder="Všechny role" /></SelectTrigger>
                            <SelectContent>
                              <SelectItem value="vse">Všechny role</SelectItem>
                              <SelectItem value="ridic">Řidič</SelectItem>
                              <SelectItem value="cyklista">Cyklista</SelectItem>
                              <SelectItem value="chodec">Chodec</SelectItem>
                              <SelectItem value="klient">Klient</SelectItem>
                            </SelectContent>
                          </Select>
                        </div>

                        <div className="space-y-2">
                          <Label>Stav</Label>
                          <Select value={statusFilter} onValueChange={setStatusFilter}>
                            <SelectTrigger className="rounded-2xl"><SelectValue placeholder="Všechny stavy" /></SelectTrigger>
                            <SelectContent>
                              <SelectItem value="vse">Všechny stavy</SelectItem>
                              <SelectItem value="novy">Nový</SelectItem>
                              <SelectItem value="kontaktovan">Kontaktovaný</SelectItem>
                              <SelectItem value="aktivni">Aktivní</SelectItem>
                              <SelectItem value="zamitnut">Zamítnutý</SelectItem>
                            </SelectContent>
                          </Select>
                        </div>
                      </CardContent>
                    </Card>

                    <Card className="rounded-3xl border-black/10 shadow-sm bg-black text-white">
                      <CardHeader>
                        <CardTitle className="text-xl">Chytré párování</CardTitle>
                      </CardHeader>
                      <CardContent>
                        <div className="rounded-2xl bg-white/10 p-4 text-sm text-white/90">{matchingSuggestion}</div>
                      </CardContent>
                    </Card>
                  </div>

                  <div className="space-y-4">
                    <div className="flex flex-wrap items-center justify-between gap-3">
                      <div>
                        <h2 className="text-2xl font-extrabold">Přehled zájemců a klientů</h2>
                        <p className="text-black/65">Tady třídíš, hledáš a rozhoduješ, kdo je vhodný pro spolupráci.</p>
                      </div>
                      <Button className="rounded-2xl bg-yellow-400 text-black hover:bg-yellow-300">Vytvořit kampaň</Button>
                    </div>

                    <div className="grid gap-4">
                      {filtered.length ? filtered.map((item) => (
                        <LeadCard key={item.id} item={item} onStatus={updateStatus} />
                      )) : (
                        <Card className="rounded-3xl border-dashed border-black/15 shadow-none">
                          <CardContent className="p-10 text-center text-black/55">Nic nebylo nalezeno pro aktuální filtry.</CardContent>
                        </Card>
                      )}
                    </div>
                  </div>
                </div>
              </TabsContent>
            </Tabs>
          </div>
        </div>
      </div>
    </div>
  );
}
