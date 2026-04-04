# Moodle Quiz Generator Plugin

Plugin for **Moodle 4.5+** that generates quiz questions using AI and imports them directly into the Moodle question bank.

The plugin supports generating quizzes for the following study subjects:

- **Programming in C**
- **Programming in C++**
- **Programming in Java**
- **Computer Architecture**
- **Data Structures and Algorithms**

The plugin uses the **Moodle AI subsystem** and converts AI-generated **JSON** into **Moodle XML**, allowing the questions to be automatically imported into a selected question category.

---

# Table of Contents

- [Lietuviška dokumentacija](#lietuviška-dokumentacija)
  - [Apie plėtinį](#apie-plėtinį)
  - [Plėtinio veikimas](#plėtinio-veikimas)
  - [Kognityvinis sudėtingumas](#kognityvinis-sudėtingumas)
  - [JSON pavyzdžiai](#json-pavyzdžiai)
  - [Kategorija](#kategorija)
  - [Kaip pasiekiamas plėtinys](#kaip-pasiekiamas-plėtinys)
  - [Plėtinio instaliavimas](#plėtinio-instaliavimas)
  - [DI konfiguravimas](#di-konfiguravimas)

- [English documentation](#english-documentation)
  - [About plugin](#about-plugin)
  - [How the plugin works](#how-the-plugin-works)
  - [Cognitive complexity](#cognitive-complexity)
  - [JSON examples](#json-examples)
  - [Category](#category)
  - [Plugin installation](#plugin-installation)
  - [AI configuration](#ai-configuration)

---

# Lietuviška dokumentacija

## Apie plėtinį

Šis plėtinys leidžia generuoti **Moodle viktorinas**, skirtas 5 studijuojamiems dalykams:

- **Programavimas C kalba**
- **Programavimas C++ kalba**
- **Programavimas Java kalba**
- **Kompiuterių architektūra**
- **Duomenų struktūros ir algoritmai**

Plėtinys pasitelkia **Moodle DI posistemę**, kuri leidžia administratoriui Moodle aplinkoje sukonfigūruoti pageidaujamą dirbtinio intelekto tiekėją.

DI pats negeneruoja Moodle XML formato viktorinos. Vietoje to jis grąžina **JSON struktūrą**, kuri plėtinyje saugiai konvertuojama į **Moodle XML** ir importuojama į pasirinktą klausimų kategoriją.

**Svarbu:** plėtinys veikia tik su **Moodle 4.5+** versija.

---

## Plėtinio veikimas

Atidarius plėtinį vartotojui pateikiama forma, kurioje galima pasirinkti arba įvesti:

- **Studijų dalyką**
- **Viktorinos temą**
- **Klausimų skaičių**
- **Kognityvinį generuojamų klausimų sudėtingumą**
- **JSON pavyzdžius**
- **Kategoriją**

Šie parametrai siunčiami į Moodle DI posistemę, kuri perduoda užklausą pasirinktam DI modeliui. Sugeneruoti klausimai grąžinami **JSON formatu**, kuris plėtinyje konvertuojamas į **Moodle XML** ir importuojamas į pasirinktą kategoriją.

---

## Kognityvinis sudėtingumas

Formoje galima pasirinkti klausimų **kognityvinį sudėtingumą**. Tai būdas klasifikuoti klausimus pagal skirtingus mąstymo procesus.

Naudojama **2001 m. atnaujinta Blumo taksonomija**, kurioje išskiriami 6 lygiai:

- Atsiminti
- Suprasti
- Taikyti
- Analizuoti
- Įvertinti
- Kurti

Norint paskatinti DI generuoti tam tikro sudėtingumo klausimus, naudojamas metodas **Few-shot prompting**, t. y. pateikiami pavyzdiniai klausimai.

---

## JSON pavyzdžiai

Vartotojas gali pasirinkti **JSON pavyzdžius**, kurie bus pridėti prie DI užklausos kartu su viktorinos parametrais. Tai leidžia pagerinti generuojamų klausimų kokybę.

Plėtinys turi **numatytuosius pavyzdžius visiems 5 studijų dalykams**, tačiau rekomenduojama kurti papildomus pagal konkrečius poreikius.

Formoje yra veiksmas **„Tvarkyti pavyzdžius“**, kuris atidaro kitą puslapį, kuriame galima:

- pasirinkti **pavyzdžių kalbą**
- pasirinkti **studijų dalyką**
- suteikti **failo pavadinimą**
- įkelti iki **6 JSON failų**

Leidžiami failų pavadinimai:

```
lvl1
lvl2
lvl3
lvl4
lvl5
lvl6
```

Taip pat pateikiama lentelė su anksčiau įkeltais pavyzdžiais, kur juos galima **peržiūrėti arba pašalinti**.

**Svarbu:** įkelti pavyzdžiai yra **susieti su kursu**, kuriame jie buvo išsaugoti. Kituose kursuose jie nebus matomi.

JSON failo struktūra:

```
{
	"questions": [
		{
			"name": "<klausimo pavadinimas>",
			"questiontext": "<klausimo tekstas>",
			"questiontype": "<multichoice | shortanswer | essay>",
			"code": "<kodo sakiniai>",
			"answers": [
				{
					"text": "<atsakymo tekstas>",
					"fraction": 100
				},
				{
					"text": "<atsakymo tekstas>",
					"fraction": 0
				},
				{
					"text": "<atsakymo tekstas>",
					"fraction": 0
				},
				{
					"text": "<atsakymo tekstas>",
					"fraction": 0
				}
			]
		},
    ]
}
```

---

## Kategorija

Galima pasirinkti **klausimų kategoriją**, į kurią bus importuojami sugeneruoti klausimai.

**Svarbu:** prieš naudojant plėtinį kurse turi būti sukurta bent viena klausimų kategorija.

---

## Kaip pasiekiamas plėtinys

Plėtinį galima pasiekti per:

```
Mano kursai → Kursas → Daugiau → Viktorinos generatorius
```

---

## Plėtinio instaliavimas

Plėtinį galima įdiegti nukopijuojant jį į:

```
server/moodle/local
```

Atnaujinus Moodle puslapį, automatiškai bus paleistas plėtinio diegimo procesas.

**Svarbu:** prieš naudojant plėtinį būtina sukonfigūruoti DI tiekėją.

---

## DI konfiguravimas

Atidarykite:

```
Administravimas → DI → DI teikėjai
```

Čia galima:

- įjungti DI tiekėją
- įvesti **API raktą**
- nustatyti **naudojimo apribojimus**

Šiuo metu Moodle nepalaiko kai kurių tiekėjų, pvz., **Anthropic (Claude)**, tačiau palaikomų modelių sąrašas ateityje turėtų plėstis.

Taip pat egzistuoja plėtinys, integruojantis **Google Gemini API**:

https://moodle.org/plugins/aiprovider_gemini

---

# English documentation

## About plugin

This plugin allows generating **Moodle quizzes** for five study subjects:

- **Programming in C**
- **Programming in C++**
- **Programming in Java**
- **Computer Architecture**
- **Data Structures and Algorithms**

The plugin uses the **Moodle AI subsystem**, allowing administrators to configure the AI provider within Moodle.

The AI **does not generate Moodle XML directly**. Instead, it returns **JSON**, which the plugin safely converts into **Moodle XML** and imports into the selected question category.

**Important:** the plugin works on **Moodle 4.5+**.

---

## How the plugin works

When opened, the plugin presents a form where users can specify:

- **Study subject**
- **Quiz topic**
- **Number of questions**
- **Cognitive complexity**
- **JSON examples**
- **Question category**

The plugin sends these parameters to the configured AI provider. The AI generates quiz questions in **JSON format**, which the plugin converts into **Moodle XML** and imports into the selected category.

---

## Cognitive complexity

The form allows selecting the **cognitive complexity** of generated questions.

This classification is based on the **revised Bloom’s Taxonomy (2001)**, which defines six levels:

- Remember
- Understand
- Apply
- Analyze
- Evaluate
- Create

To guide the AI toward generating questions at the selected cognitive level, the plugin uses **few-shot prompting** with example questions.

---

## JSON examples

Users can select **JSON examples** that will be appended to the AI request to improve output quality.

The plugin provides **default examples for all five study subjects**, but users can also create their own.

The **"Manage examples"** action opens a form where users can:

- select the **language**
- select the **study subject**
- provide a **file name**
- upload up to **6 JSON files**

Allowed file names:

```
1lvl
2lvl
3lvl
4lvl
5lvl
6lvl
```

A table below the form lists previously uploaded examples, which can be **previewed or removed**.

**Important:** examples are **course-specific** and are only visible in the course where they were uploaded.

JSON file structure:

```
{
	"questions": [
		{
			"name": "<name of the question>",
			"questiontext": "<question text>",
			"questiontype": "<multichoice | shortanswer | essay>",
			"code": "<lines of code>",
			"answers": [
				{
					"text": "<answer text>",
					"fraction": 100
				},
				{
					"text": "<answer text>",
					"fraction": 0
				},
				{
					"text": "<answer text>",
					"fraction": 0
				},
				{
					"text": "<answer text>",
					"fraction": 0
				}
			]
		},
    ]
}
```

---

## Category

Users must select the **question category** where generated questions will be imported.

**Important:** at least one category must exist in the course before using the plugin.

---

## Plugin installation

Copy the plugin into:

```
server/moodle/local
```

After refreshing the page, Moodle will automatically start the plugin installation process.

---

## AI configuration

Open:

```
Site administration → AI → AI providers
```

Here administrators can:

- enable an AI provider
- enter the **API key**
- configure **usage limits**

Currently Moodle does not support some providers such as **Anthropic (Claude)**.
