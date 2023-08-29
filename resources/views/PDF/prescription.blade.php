<!DOCTYPE html>
<html>
<head>
<title>Prescription - PDF</title>

<style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
      -webkit-print-color-adjust: exact;
      print-color-adjust: exact;
      color-adjust: exact;
    }
    
    body {
      height: 100vh;
      display: grid;
      place-items: center;
    }
    
    .invoice {
      width: min(600px,90vw);
      font: 100 0.7rem 'myriad pro',helvetica,sans-serif;
      border: 0.5px solid black;
      padding: 4rem 3rem;
      display: flex;
      flex-direction: column;
      gap: 3rem;
    }
    
    .invoice-wrapper {
      display: flex;
      justify-content: space-between;
      padding: 0 1rem;
    }
    
    .invoice-company { text-align: right; }
    
    .invoice-company-name {
      font-size: 0.9rem;
      margin-bottom: 1.25rem;
    }
    
    .invoice-company-address {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }
    
    .invoice-logo {
      width: 5rem;
      height: 5rem;
    }
    
    .invoice-billing-company {
      font-size: 0.65rem;
      margin-bottom: 0.25rem;
    }
    
    .invoice-billing-address {
      display: flex;
      flex-direction: column;
      gap: 0.25rem;
    }
    
    .invoice-info {
      display: flex;
      justify-content: space-between;
      gap: 2rem; 
      margin: 0.25rem 0;
    }
    
    .invoice-info:nth-of-type(5) { margin-top: 1.5rem; }
    .invoice-info-value { font-weight: 900; }
    .invoicetable { width: 100%; }
    .invoice-table, th, td { border-collapse: collapse; }
    
    th, td {
      width: calc((600px - 3rem) / 4);
      text-align: center;
      padding: 0.75rem;
    }
    
    tr:nth-of-type(1) { background-color: rgba(0,0,0,0.2); }
    tr:nth-of-type(2), tr:nth-of-type(3) { border-bottom: 0.5px solid rgba(0,0,0,0.25); }
    
    .invoice-total { font-weight: 900; }
    
    .invoice-print {
      font-size: 1.25rem;
      margin: 0 auto;
      cursor: pointer;
      border: 1.25px solid black;
      border-radius: 50%;
      padding: 0.6rem;
    }
    
    .invoice-print:active {
      background-color: black;
      color: white;
    }
</style>

</head>
<body>
<main class='invoice'>
  <div class='invoice-wrapper'>
    <img src='https://gist.githubusercontent.com/mondenoir/bab1c3ffbc9e6a6939d47d702be9a63f/raw/91e20eed0549f41528689256f2364e34edaceec3/logo.svg' alt='logo' class='invoice-logo'>
    <div class='invoice-company'>
      <h2 class='invoice-company-name'>HELIX DESIGN</h2>
      <p class='invoice-company-address'>
        <span>168 Market Street</span>
        <span>San Francisco, CA</span>
        <span>susanvegas@helix.com</span>
      </p>
    </div>
  </div>
  <div class='invoice-wrapper'>
    <div class='invoice-billing'>
      <h2 class='invoice-billing-company'>APEX INC.</h2>
      <p class='invoice-billing-address'>
        <span>2258 Lansing Blvd</span>
        <span>Detroid, Michigan</span>
      </p>
    </div>
    <div class='invoice-details'>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Invoice No:</span>
        <span class='invoice-info-value'>001230</span>
      </div>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Client Number:</span>
        <span class='invoice-info-value'>333</span>
      </div>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Issue Date:</span>
        <span class='invoice-info-value'>10/05/2033</span>
      </div>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Due Date:</span>
        <span class='invoice-info-value'>11/05/2033</span>
      </div>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Reference:</span>
        <span class='invoice-info-value'>083922</span>
      </div>
      <div class='invoice-info'>
        <span class='invoice-info-key'>Delivery Date:</span>
        <span class='invoice-info-value'>10/08/2033</span>
      </div>
    </div>
  </div>
  <table class='invoice-table'>
    <tr>
      <th>DESCRIPTION</th>
      <th>QUANTITY</th>
      <th>PRICE</th>
      <th>AMOUNT</th>
    </tr>
    <tr>
      <td>WEB DESIGN</td>
      <td>1</td>
      <td>3000.00</td>
      <td>3000.00</td>
    </tr>
    <tr>
      <td>BRANDING</td>
      <td>1</td>
      <td>2000.00</td>
      <td>2000.00</td>
    </tr>
    <tr>
      <td>-</td>
      <td>-</td>
      <td>-</td>
      <td class='invoice-total'>5000.00</td>
    </tr>
  </table>
  <ion-icon name="print-outline" class='invoice-print'></ion-icon>
</main>

<script type="module" src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.esm.js"></script>
<script nomodule src="https://unpkg.com/ionicons@7.1.0/dist/ionicons/ionicons.js"></script>
</body>
</html>