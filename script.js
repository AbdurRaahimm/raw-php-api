const form = document.querySelector('form');

form.addEventListener('submit', async function (e) {
    e.preventDefault();

    let name = form.querySelector('[name="name"]').value;
    let city = form.querySelector('[name="city"]').value;
    let salary = form.querySelector('[name="salary"]').value;
    let age = form.querySelector('[name="age"]').value;

    // Perform input validation
    if (!name || !city || !salary || !age) {
        alert('Please fill in all fields.');
        return;
    }

    // Optionally, perform more specific validation on each field

    let data = {
        name: name,
        city: city,
        salary: salary,
        age: age
    };
    console.log(data);
    try {
        let response = await fetch('http://localhost:441/raw-php-api', {
            method: 'POST',
            // headers: {
            //     'Content-Type': 'application/json'
            // },
            body: JSON.stringify(data)
        });

        if (!response.ok) {
            throw new Error('Network response was not ok');
        }

        let result = await response.json();
        console.log(result);
        // Optionally handle the result, like displaying a success message
    } catch (error) {
        console.error('Error:', error);
        // Optionally, handle errors, like displaying an error message to the user
    }
});





async function getData() {
    let response = await fetch('http://localhost:441/raw-php-api');
    let data = await response.json();
    return data;
}

getData().then(data => {
    console.log(data);

    let html = '';
    data.forEach(element => {
        html += `
            <tr>
                <td>${element.EMP_ID}</td>
                <td>${element.EMP_NAME}</td>
                <td>${element.CITY}</td>
                <td>${element.SALARY}</td>
                <td>${element.AGE}</td>
                <td>
                    <button onclick="edit(${element.EMP_ID})">Edit</button>
                    <button onclick="del(${element.EMP_ID})">Delete</button>
                </td>
            </tr>
        `;
    });
    document.querySelector('tbody').innerHTML = html;
});



async function edit(id) {
    let response = await fetch(`http://localhost:441/raw-php-api/?id=${id}`);
    let data = await response.json();
    console.log(data);
    let form = document.querySelector('form');
    form.querySelector('[name="name"]').value = data.EMP_NAME;
    form.querySelector('[name="city"]').value = data.CITY;
    form.querySelector('[name="salary"]').value = data.SALARY;
    form.querySelector('[name="age"]').value = data.AGE;
    console.log(form);
    document.querySelector('button').innerText = 'Update';
    document.querySelector('button').setAttribute('onclick', 'update(' + id + ')');
}

async function update(id) {
    let form = document.querySelector('form');
    let name = form.querySelector('[name="name"]').value;
    let city = form.querySelector('[name="city"]').value;
    let salary = form.querySelector('[name="salary"]').value;
    let age = form.querySelector('[name="age"]').value;
    let data = {
        name: name,
        city: city,
        salary: salary,
        age: age
    };
    console.log(data);
    let response = await fetch(`http://localhost:441/raw-php-api/?id=${id}`, {
        method: 'PUT',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify(data)
    });
    let result = await response.json();
    console.log(result);
    alert(result.message);
    location.reload();

}

async function del(id) {
    console.log(id);
    let response = await fetch(`http://localhost:441/raw-php-api/?id=${id}`, {
        method: 'DELETE',
        headers: {
            'Content-Type': 'application/json'
        }
    });
    let data = await response.json();
    console.log(data);
    alert(data.message);
    location.reload();

}