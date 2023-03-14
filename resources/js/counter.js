
export default async () => {
  var products = document.getElementsByClassName('product');
  const totalOrder = [];

  for(let x=0; x < products.length; x++){
    let productId = document.getElementsByClassName('product')[x].id;
    totalOrder.splice(x, 1, document.getElementsByClassName('unitprice')[x].value*document.getElementsByClassName('compteur')[x].value);
    total(totalOrder);
    document.getElementsByClassName('stocklimit')[x].hidden = true;
    document.getElementsByClassName('instock')[x].hidden = false;
    let unitPrice = document.getElementsByClassName('unitprice')[x];
    let textStock = document.getElementsByClassName('stock')[x];
      document.getElementsByClassName('counterp')[x].addEventListener('click', async () => {
        console.log(productId);
  //      updatecartplus(mysql);

        let response = await fetch('/increment');
        let data = await response.json();
        data.count=1;
        let textElement = document.getElementsByClassName('compteur')[x];
        if (textElement.value < parseInt(textStock.value)){
          textElement.value = data.count+parseInt(textElement.value);
          let totalPrice = unitPrice.value * textElement.value;
          document.getElementsByClassName("totalPrice")[x].innerHTML = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalPrice);
          totalOrder.splice(x, 1, totalPrice);
          total(totalOrder);
        } else {
          data.count=0;
          document.getElementsByClassName('stocklimit')[x].hidden = false;
          document.getElementsByClassName('instock')[x].hidden = true;
        }
      }
      
      );

  document.getElementsByClassName('counterm')[x].addEventListener('click', async () => {
        let response = await fetch('/increment');
        let data = await response.json();
        data.count=-1;
        const textElement = document.getElementsByClassName('compteur')[x];
        if (textElement.value > 0){
        textElement.value = data.count+parseInt(textElement.value);
        let totalPrice = unitPrice.value * textElement.value;
        document.getElementsByClassName("totalPrice")[x].innerHTML = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(totalPrice);
        document.getElementsByClassName('stocklimit')[x].hidden = true;
        document.getElementsByClassName('instock')[x].hidden = false;
        totalOrder.splice(x, 1, totalPrice);
        total(totalOrder);
        } else {
          textElement.value = 0;
        }
      }
    )
    
    document.getElementById('shipping').addEventListener('change', function() {
      let shipping=this.value;
      total(totalOrder);
    });
  }

}

function total(totalOrder){

  const sum = totalOrder.reduce((accumulator, value) => {
    return accumulator + value;
  }, 0);
  document.getElementById("totalorder").innerHTML = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(sum);
  if(sum != 0){
    let sumship = sum+parseInt(shipping.value);
 //   console.log(sumship);
  document.getElementById("totalordershipping").innerHTML = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(sumship);
  } else {
    document.getElementById("totalordershipping").innerHTML = new Intl.NumberFormat('fr-FR', { style: 'currency', currency: 'EUR' }).format(sum);
  }
  return;
};

