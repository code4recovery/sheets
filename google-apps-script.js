//what language your data is in (this affects days, types, and addresses) - en, es, fr, ja
const language = "ja";

//if you have a link column, customize this so the link redirects to the meeting detail page on your site
const baseUrl = "https://tsml-ui.code4recovery.org/tests/japan.html?meeting=";

//ok to make these a flat array if you need to customize (they are like this for copy/paste-ability from other projects)
const days = Object.values(
    {
        en: {
            friday: "Friday",
            monday: "Monday",
            saturday: "Saturday",
            sunday: "Sunday",
            thursday: "Thursday",
            tuesday: "Tuesday",
            wednesday: "Wednesday",
        },
        es: {
            friday: "Viernes",
            monday: "Lunes",
            saturday: "Sábado",
            sunday: "Domingo",
            thursday: "Jueves",
            tuesday: "Martes",
            wednesday: "Miércoles",
        },
        fr: {
            friday: "Vendredi",
            monday: "Lundi",
            saturday: "Samedi",
            sunday: "Dimanche",
            thursday: "Jeudi",
            tuesday: "Mardi",
            wednesday: "Mercredi",
        },
        ja: {
            friday: "金曜日",
            monday: "月曜日",
            saturday: "土曜日",
            sunday: "日曜日",
            thursday: "木曜日",
            tuesday: "火曜日",
            wednesday: "水曜日",
        },
    }[language]
);

//ok to make these a flat array if you need to customize (they are like this for copy/paste-ability from other projects)
const types = Object.values(
    {
        en: {
            11: "11th Step Meditation",
            "12x12": "12 Steps & 12 Traditions",
            //active: 'Active',
            "AL-AN": "Concurrent with Al-Anon",
            A: "Secular",
            ABSI: "As Bill Sees It",
            AL: "Concurrent with Alateen",
            ASL: "American Sign Language",
            B: "Big Book",
            BA: "Babysitting Available",
            BE: "Newcomer",
            BRK: "Breakfast",
            BI: "Bisexual",
            C: "Closed",
            CAN: "Candlelight",
            CF: "Child-friendly",
            D: "Discussion",
            DB: "Digital Basket",
            DD: "Dual Diagnosis",
            DR: "Daily Reflections",
            EN: "English",
            FF: "Fragrance Free",
            FR: "French",
            G: "Gay",
            GR: "Grapevine",
            H: "Birthday",
            HE: "Hebrew",
            //inactive: 'Inactive',
            //'in-person': 'In-person',
            ITA: "Italian",
            JA: "Japanese",
            KOR: "Korean",
            L: "Lesbian",
            LGBTQ: "LGBTQ",
            LIT: "Literature",
            LS: "Living Sober",
            M: "Men",
            MED: "Meditation",
            N: "Native American",
            NDG: "Indigenous",
            O: "Open",
            //online: 'Online',
            OUT: "Outdoor",
            P: "Professionals",
            POC: "People of Color",
            POL: "Polish",
            POR: "Portuguese",
            PUN: "Punjabi",
            RUS: "Russian",
            S: "Spanish",
            SEN: "Seniors",
            SM: "Smoking Permitted",
            SP: "Speaker",
            ST: "Step Study",
            T: "Transgender",
            TC: "Location Temporarily Closed",
            TR: "Tradition Study",
            W: "Women",
            X: "Wheelchair Access",
            XB: "Wheelchair-accessible Bathroom",
            XT: "Cross Talk Permitted",
            Y: "Young People",
        },
        es: {
            11: "Meditación del Paso 11",
            "12x12": "12 Pasos y 12 Tradiciones",
            //active: 'Activo',
            "AL-AN": "Concurrente con Al-Anon",
            A: "Secular",
            ABSI: "Como lo ve Bill",
            AL: "Concurrente con Alateen",
            ASL: "Lenguaje por señas",
            B: "Libro Grande",
            BA: "Guardería disponible",
            BE: "Principiantes",
            BI: "Bisexual",
            BRK: "Desayuno",
            C: "Cerrada",
            CAN: "Luz de una vela",
            CF: "Niño amigable",
            D: "Discusión",
            DB: "Canasta digital",
            DD: "Diagnóstico dual",
            DR: "Reflexiones Diarias",
            EN: "Inglés",
            FF: "Sin fragancia",
            FR: "Francés",
            G: "Gay",
            GR: "La Viña",
            H: "Cumpleaños",
            HE: "Hebreo",
            //inactive: 'Inactiva',
            //'in-person': 'En persona',
            ITA: "Italiano",
            JA: "Japonés",
            KOR: "Coreano",
            L: "Lesbianas",
            LGBTQ: "LGBTQ",
            LIT: "Literatura",
            LS: "Viviendo Sobrio",
            M: "Hombres",
            MED: "Meditación",
            N: "Nativo Americano",
            NDG: "Indígena",
            O: "Abierta",
            //online: 'En Línea',
            OUT: "Al aire libre",
            P: "Profesionales",
            POC: "Gente de color",
            POL: "Polaco",
            POR: "Portugués",
            PUN: "Punjabi",
            RUS: "Ruso",
            S: "Español",
            SEN: "Personas mayores",
            SM: "Se permite fumar",
            SP: "Orador",
            ST: "Estudio de pasos",
            T: "Transgénero",
            TC: "Ubicación temporalmente cerrada",
            TR: "Estudio de tradicion",
            W: "Mujer",
            X: "Acceso en silla de ruedas",
            XB: "Baño accesible para sillas de ruedas",
            XT: "Se permite opinar",
            Y: "Gente joven",
        },
        fr: {
            11: "Méditation sur la 11e Étape",
            "12x12": "12 Étapes et 12 Traditions,",
            //active: 'Actives',
            "AL-AN": "En même temps qu’Al-Anon",
            A: "Séculier",
            ABSI: "Réflexions de Bill",
            AL: "En même temps qu’Alateen",
            ASL: "Langage des Signes",
            B: "Gros Livre",
            BA: "Garderie d’enfants disponible",
            BE: "Nouveau/nouvelle",
            BI: "Bisexuel",
            BRK: "Petit déjeuner",
            C: "Fermé",
            CAN: "À la chandelle",
            CF: "Enfants acceptés",
            D: "Discussion",
            DB: "Panier numérique",
            DD: "Double diagnostic",
            DR: "Réflexions quotidiennes",
            EN: "Anglais",
            FF: "Sans parfum",
            FR: "Français",
            G: "Gai",
            GR: "Grapevine",
            H: "Anniversaire",
            HE: "Hébreu",
            //inactive: 'Inactives',
            //'in-person': 'En personne',
            ITA: "Italien",
            JA: "Japonais",
            KOR: "Coréen",
            L: "Lesbienne",
            LGBTQ: "LGBTQ",
            LIT: "Publications",
            LS: "Vivre… Sans alcool",
            M: "Hommes",
            MED: "Méditation",
            N: "Autochtone",
            NDG: "Indigène",
            O: "Ouvert(e)",
            //online: 'En ligne',
            OUT: "En plein air",
            P: "Professionnels",
            POC: "Gens de couleur",
            POL: "Polonais",
            POR: "Portugais",
            PUN: "Pendjabi",
            RUS: "Russe",
            S: "Espagnol",
            SEN: "Séniors",
            SM: "Permis de fumer",
            SP: "Conférencier",
            ST: "Sur les Étapes",
            T: "Transgenre",
            TC: "Emplacement temporairement fermé",
            TR: "Étude des Traditions",
            W: "Femmes",
            X: "Accès aux fauteuils roulants",
            XB: "Toilettes accessibles aux fauteuils roulants",
            XT: "Conversation croisée permise",
            Y: "Jeunes",
        },
        ja: {
            11: "第11ステップの瞑想",
            "12x12": "12のステップと12の伝統",
            //active: 'アクティブ',
            "AL-AN": "アラノンと同時進行",
            A: "世俗的な",
            ABSI: "ビルの見方",
            AL: "アラティーンと同時進行",
            ASL: "アメリカの手話",
            B: "ビッグブック",
            BA: "託児あり",
            BE: "新人",
            BRK: "朝ごはん",
            BI: "バイセクシャル",
            C: "閉まっている",
            CAN: "キャンドルライト",
            CF: "子供に優しい",
            D: "討論",
            DB: "デジタルバスケット",
            DD: "二重診断",
            DR: "日々の振り返り",
            EN: "英語",
            FF: "無香料",
            FR: "フランス語",
            G: "ゲイ",
            GR: "グレープバイン",
            H: "誕生日",
            HE: "ヘブライ語",
            //inactive: '非活性',
            //'in-person': '対面',
            ITA: "イタリアの",
            JA: "日本",
            KOR: "韓国語",
            L: "レズビアン",
            LGBTQ: "LGBTQ",
            LIT: "文学",
            LS: "しらふ生活",
            M: "男性",
            MED: "瞑想",
            N: "ネイティブアメリカン",
            NDG: "先住民",
            O: "開ける",
            //online: 'オンライン',
            OUT: "アウトドア",
            P: "プロフェッショナル",
            POC: "色の人々",
            POL: "研磨",
            POR: "ポルトガル語",
            PUN: "パンジャブ語",
            RUS: "ロシア",
            S: "スペイン語",
            SEN: "高齢者",
            SM: "喫煙可",
            SP: "スピーカー",
            ST: "ステップスタディ",
            T: "トランスジェンダー",
            TC: "場所は一時的に閉鎖されています",
            TR: "伝統研究",
            W: "女性",
            X: "車椅子アクセス",
            XB: "車椅子対応バスルーム",
            XT: "クロストーク許可",
            Y: "若者たち",
        },
    }[language]
);

const errors = {
    en: {
        day: "Invalid day: %d%",
        name: "Name is required",
        slug_required: "Slug is required",
        slug_unique: "Slug must be unique",
        types: "Invalid types: %t%",
    },
    es: {
        day: "Día inválido: %d%",
        name: "Se requiere el nombre",
        slug_required: "Se requiere babosa",
        slug_unique: "Babosa debe ser única",
        types: "Tipos no válidos: %t%",
    },
    fr: {
        day: "Jour invalide : %d%",
        name: "Le nom est requis",
        slug_required: "Slug est requis",
        slug_unique: "Slug doit être unique",
        types: "Types non valides : %t%",
    },
    ja: {
        day: "無効な日: %d%",
        name: "お名前必須",
        slug_required: "スラグが必要です",
        slug_unique: "スラッグは一意でなければなりません",
        types: "無効なタイプ: %t%",
    },
}[language];

function getColumnValues(sheet, headers, header) {
    const columnIndex = headers.indexOf(header);
    if (columnIndex === -1) return [];
    return sheet
        .getRange(2, columnIndex + 1, sheet.getLastRow() - 1)
        .getValues()
        .map((arr) => arr.pop());
}

function getHeaders(sheet) {
    return sheet
        .getSheetValues(1, 1, 1, sheet.getLastColumn())
        .pop()
        .map((value) =>
            value.toString().trim().toLowerCase().replaceAll(" ", "_")
        );
}

function isInvalid(sheet, headers, header, value) {
    if (typeof value === "undefined") value = false;

    if (header === "types") {
        const invalidTypes = value
            .split(",")
            .map((type) => type.trim())
            .filter((type) => !types.includes(type));
        return invalidTypes.length
            ? errors.types.replace("%t%", invalidTypes.join(", "))
            : null;
    } else if (header === "day" && value && !days.includes(value)) {
        return errors.day.replace("%d%", value);
    } else if (header === "name" && !value) {
        return errors.name;
    } else if (header === "slug") {
        if (!value) {
            return errors.slug_required;
        } else if (
            getColumnValues(sheet, headers, "slug").filter((e) => e === value)
                .length > 1
        ) {
            return errors.slug_unique;
        }
    }
    return null;
}

function onEdit(e) {
    const sheet = SpreadsheetApp.getActiveSheet();
    const row = e.range.getRow();
    const value = e.range.getValue().toString();
    const headers = getHeaders(sheet);
    const header = headers[e.range.getColumn() - 1];
    const rowValues = sheet.getRange(row, 1, 1, headers.length).getValues()[0];

    //stop if first, after last, or row is empty
    if (
        row === 1 ||
        row > sheet.getLastRow() ||
        !rowValues.filter((e) => e).length
    )
        return;

    //dynamic data
    if (header === "name") {
        setSlugIfEmpty(sheet, headers, row, value);
    } else if (header === "formatted_address") {
        if (value) {
            const response = Maps.newGeocoder()
                .setLanguage(language)
                .geocode(value);
            if (response.results.length) {
                const {
                    address_components,
                    formatted_address,
                    geometry: { bounds, location, location_type },
                } = response.results[0];

                //set formatted_address column
                setValue(
                    sheet,
                    headers,
                    "formatted_address",
                    row,
                    formatted_address
                );

                //set address column
                const address = address_components
                    .filter(({ types }) =>
                        types.some((type) =>
                            [
                                "street_number",
                                "route",
                                "premise",
                                "sublocality_level_4",
                                "sublocality_level_3",
                            ].includes(type)
                        )
                    )
                    .map(({ short_name }) => short_name)
                    .join(" ");
                setValue(sheet, headers, "address", row, address);

                //set coordinates column
                const coordinates =
                    location_type === "APPROXIMATE"
                        ? [
                              bounds.northeast.lat,
                              bounds.northeast.lng,
                              bounds.southwest.lat,
                              bounds.southwest.lng,
                          ]
                        : [location.lat, location.lng];
                setValue(
                    sheet,
                    headers,
                    "coordinates",
                    row,
                    coordinates
                        .map(
                            (coordinate) =>
                                Math.round(parseFloat(coordinate) * 100000) /
                                100000
                        )
                        .join()
                );

                //set regions column
                const regions = address_components
                    .filter(({ types }) =>
                        types.some((type) =>
                            ["locality", "sublocality_level_2"].includes(type)
                        )
                    )
                    .map(({ long_name }) => long_name)
                    .reverse()
                    .join(" > ");
                setValue(sheet, headers, "regions", row, regions);
            }
        } else {
            setValue(sheet, headers, "address", row, "");
            setValue(sheet, headers, "coordinates", row, "");
            setValue(sheet, headers, "regions", row, "");
        }
    } else if (header === "slug") {
        const slug = slugify(value);
        setValue(sheet, headers, "slug", row, slug);
        setLink(sheet, headers, row, slug);
    } else if (header === "types") {
        const meetingTypes = value.split(",").map((type) => type.trim());
        meetingTypes.sort();
        setValue(sheet, headers, "types", row, meetingTypes.join(", "));
    }

    //set updated
    if (rowValues.length > 1) {
        const now = new Date();
        const utc = new Date(now.getTime() + now.getTimezoneOffset() * 60000);
        setValue(sheet, headers, "updated", row, utc);
    } else {
        setValue(sheet, headers, "updated", row, null);
    }

    //set note for invalid data
    e.range.setNote(isInvalid(sheet, headers, header, value));
}

function setLink(sheet, headers, row, slug) {
    const sheetId = SpreadsheetApp.getActiveSpreadsheet().getId();
    const value = `=HYPERLINK("https://sheets.code4recovery.org/${sheetId}?redirectTo=${encodeURIComponent(
        baseUrl
    )}${slug}", "LINK")`;
    setValue(sheet, headers, "link", row, value);
}

function setSlugIfEmpty(sheet, headers, row, name) {
    const column = headers.indexOf("slug");
    if (column === -1) return;
    const range = sheet.getRange(row, column + 1);
    if (!range.getValue().toString().trim().length) {
        const slug = slugify(name);
        range.setValue(slug);
        setLink(sheet, headers, row, slug);
    }
}

function setValue(sheet, headers, header, row, value) {
    const column = headers.indexOf(header);
    if (column === -1) return;
    const range = sheet.getRange(row, column + 1);
    if (value !== range.getValue().toString()) {
        range.setValue(value);
    }
}

function slugify(str) {
    str = str.trim().toLowerCase();

    // remove accents, swap ñ for n, etc
    const from = "åàáãäâèéëêìíïîòóöôùúüûñç·/_,:;";
    const to = "aaaaaaeeeeiiiioooouuuunc------";

    for (let i = 0, l = from.length; i < l; i++) {
        str = str.replace(new RegExp(from.charAt(i), "g"), to.charAt(i));
    }

    return (
        str
            //.replace(/[^a-z0-9 -]/g, '') // remove invalid chars
            .replace(/\s+/g, "-") // collapse whitespace and replace by -
            .replace(/-+/g, "-") // collapse dashes
            .replace(/^-+/, "") // trim - from start of text
            .replace(/-+$/, "")
    ); // trim - from end of text
}
