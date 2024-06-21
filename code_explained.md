## Uitleg van de `getPriceSummary` functie

### Functieoverzicht
De `getPriceSummary` functie verzamelt en formatteert prijsinformatie van verschillende HTML-elementen op een webpagina en retourneert een samenvatting van de prijzen. De informatie bevat de bezoekprijs, bestelde versnaperingen en de totaalprijs.

### Stappen in de Functie

1. **Verkrijgen van de bezoekprijs**

    ```javascript
    const bezoekDiv = document.getElementById('bezoek').innerText.trim();
    ```

    - **`document.getElementById('bezoek')`**: Haalt het HTML-element op met de ID `bezoek`.
    - **`innerText`**: Haalt de tekstinhoud van het element op.
    - **`trim()`**: Verwijdert eventuele witruimtes aan het begin en einde van de tekst.

2. **Loggen van de bezoekprijs**

    ```javascript
    console.log("bezoekDiv: ", bezoekDiv);
    ```

3. **Verkrijgen van de voedsel samenvatting items**

    ```javascript
    const foodSummaryItems = Array.from(document.getElementById('foodSummary').getElementsByClassName('summary-item'))
        .map(item => item.innerText.replace(/\n/g, ' ').replace(/: /g, ': '))
        .join('\n- ');
    ```

    - **`document.getElementById('foodSummary')`**: Haalt het HTML-element op met de ID `foodSummary`.
    - **`getElementsByClassName('summary-item')`**: Haalt een collectie op van alle elementen met de klasse `summary-item` binnen het `foodSummary` element.
    - **`Array.from()`**: Zet de HTML-collectie om in een array.
    - **`map(item => item.innerText.replace(/\n/g, ' ').replace(/: /g, ': '))`**: 
        - **`item.innerText`**: Haalt de tekstinhoud van elk element op.
        - **`replace(/\n/g, ' ')`**: Vervangt nieuwe regels met een spatie.
        - **`replace(/: /g, ': ')`**: Vervangt ": " met ": ".
    - **`join('\n- ')`**: Voegt de items samen tot één string, waarbij elk item voorafgegaan wordt door `\n- `.

4. **Loggen van de voedsel samenvatting items**

    ```javascript
    console.log("foodsummaryItems: ", foodSummaryItems);
    ```

5. **Verkrijgen van de totaalprijs**

    ```javascript
    const totalPrice = document.getElementById('totalPrice').innerText;
    ```

    - **`document.getElementById('totalPrice')`**: Haalt het HTML-element op met de ID `totalPrice`.
    - **`innerText`**: Haalt de tekstinhoud van het element op.

6. **Samenstellen van de prijs samenvatting**

    ```javascript
    let priceSummary = `-Bezoekprijs:\n${padString('', bezoekDiv)}`;
    if (foodSummaryItems) {
        priceSummary += `\nBestelde versnaperingen:\n- ${foodSummaryItems}`;
    }
    priceSummary += `\n\nTotaalprijs: €${totalPrice}`;
    ```

    - **`let priceSummary`**: Declareert een variabele `priceSummary` en stelt deze in met een geformatteerde string die de bezoekprijs bevat.
    - **`if (foodSummaryItems)`**: Controleert of er voedsel samenvatting items zijn.
        - Als `foodSummaryItems` niet leeg is, wordt het toegevoegd aan `priceSummary` met een koptekst.
    - **`priceSummary += `\n\nTotaalprijs: €${totalPrice}`**: Voegt de totaalprijs toe aan de samenvatting.

7. **Retourneren van de prijs samenvatting**

    ```javascript
    return priceSummary;
    ```

    - De functie retourneert de geformatteerde prijs samenvatting als een string.


