
export default function updatecartplus(mysql){
//const prodID = productID;
const connection = mysql.createConnection({
    host: '127.0.0.1',
    user: 'root',
    password: '',
    database: 'eshop'
  });
  connection.connect((err) => {
    if (err) throw err;
    console.log('Connected!');
  });
}
