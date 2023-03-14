export default async () => {
    let writer = document.getElementById('write');
  
    writer.addEventListener('click', async () => {
      let input = document.getElementById('name').value;
  
      let response = await fetch('/name', {
        method: 'POST',
        body: JSON.stringify({'user': input}),
        headers: {
          'Content-Type': 'application/json',
        },
      });
  
      let data = await response.json();
  
      const textElement = document.getElementById('user');
      textElement.innerText = data.data;
    });
  }
  