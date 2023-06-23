import './App.css';
import { useEffect, useState } from 'react';
import axios from 'axios';

const UFS = ["AC", "AL", "AP", "AM", "BA", "CE", "DF", "ES", "GO", "MA", "MT", "MS", "MG",
  "PA", "PB", "PR", "PE", "PI", "RJ", "RN", "RS", "RO", "RR", "SC", "SP", "SE", "TO"];

function App() {
  const [name, setName] = useState("");
  const [CPF, setCPF] = useState("");
  const [RG, setRG] = useState("");
  const [CEP, setCEP] = useState("");
  const [Logradouro, setLogradouro] = useState("");
  const [Complemento, setComplemento] = useState("");
  const [Setor, setSetor] = useState("");
  const [Cidade, setCidade] = useState("");
  const [UF, setUF] = useState("");
  const [inputCount, setInputCount] = useState(5);
  const [inputNumeros, setInputNumeros] = useState([]);
  const [inputDescricao, setInputDescricao] = useState([]);
  const [dados, setDados] = useState([]);
  const [update, setUpdate] = useState(true);
  const [deleteButton, setDeleteButton] = useState(true);
  const [editPhone, setEditPhone] = useState([]);
  const [userId, setUserId] = useState("");
  const [telefones, setTelefones] = useState([]);
  const [boolean, setBoolean] = useState(false);

  function editar(id) {
    setBoolean(true);
    setDeleteButton(false);
    setUserId(id);

    const edit = dados.filter((dado) => {
      return dado.Id === id
    })

    let arr = [];
    const tam = edit[0].Telefone.length < 5 ? 5 : edit[0].Telefone.length;

    for (let i = 0; i < tam; i++) {
      arr.push({
        phoneNumber: edit[0].Telefone[i] ? edit[0].Telefone[i].phoneNumber : "",
        phoneDescription: edit[0].Telefone[i] ? edit[0].Telefone[i].phoneDescription : ""
      })
    }
    setTelefones(arr);

    console.log(edit[0].Telefone);
    setEditPhone(edit[0].Telefone);
    setName(edit[0].nome);
    setCPF(edit[0].CPF);
    setRG(edit[0].RG);
    setCEP(edit[0].CEP);
    setLogradouro(edit[0].Logradouro);
    setComplemento(edit[0].Complemento);
    setSetor(edit[0].Setor);
    setCidade(edit[0].Cidade);
    setUF(edit[0].UF);
  }

  function deletar() {
    axios.delete('http://localhost/crud_php_react/api.php/' + userId)
      .then((response) => {
        console.log(response.data);
      })
      .catch((response) => {
        console.log(response.data);
      })

    setUpdate(!update);
  }

  function criaObjeto() {
    const objetoCadastro = {
      name: name, cpf: CPF, rg: RG, cep: CEP, logradouro: Logradouro,
      complemento: Complemento, setor: Setor, cidade: Cidade, uf: UF, phones: telefones
    }

    axios.post('http://localhost/crud_php_react/api.php', { objetoCadastro })
      .then((response) => {
        console.log(response.data);
      }).catch((error) => {
        console.log(error);
      })

    setUpdate(!update);
  }

  useEffect(() => {
    axios.get('http://localhost/crud_php_react/api.php')
      .then((response) => {
        console.log(response);
        const novosDados = response.data.map((n) => {
          let telefones = JSON.parse(n.phones);
          return {
            nome: n.name,
            CPF: n.cpf,
            RG: n.rg,
            CEP: n.cep,
            Logradouro: n.logradouro,
            Complemento: n.complemento,
            Setor: n.setor,
            Cidade: n.cidade,
            UF: n.uf,
            Telefone: telefones,
            Id: n.id
          }
        });

        let arr = [];
        const tam = telefones.length < 5 ? 5 : telefones.length;
        for (let i = 0; i < tam; i++) {
          arr.push({
            phoneNumber:telefones[i] ? telefones[i].phoneNumber : "",
            phoneDescription: telefones[i] ? telefones[i].phoneDescription : ""
          })
        }

        setTelefones(arr);
        console.log(telefones);
        setDados(novosDados);
      }).catch((error) => {
        console.log(error);
      })
  }, [update]);

  const handleTelefoneNumero = (event, index) => {
    const { value } = event.target;

    setInputNumeros((prevValues) => {
      const updatedValues = [...prevValues];
      updatedValues[index] = value;
      return updatedValues;
    });
  };

  const handleDescricaoNumero = (event, index) => {
    const { value } = event.target;

    setInputDescricao((prevValues) => {
      const updatedValues = [...prevValues];
      updatedValues[index] = value;
      return updatedValues;
    });
  };

  function teste() {
    console.log("Oi");
    const objetoCadastro = {
      name: name, cpf: CPF, rg: RG, cep: CEP, logradouro: Logradouro,
      complemento: Complemento, setor: Setor, cidade: Cidade, uf: UF, phones: telefones
    }

    axios.put('http://localhost/crud_php_react/api.php/' + userId, {objetoCadastro})
      .then((response) => {
        console.log(response.data);
      })
    console.log(editPhone);
    console.log(objetoCadastro);
  }

  return (
    <div className="App">
      <div className="Forms">
        <div className="PersonForms">
          <h1>Cadastro de pessoa</h1>
          <div className="Form">
            <h2>Nome:</h2>
            <input type="text" value={name} onChange={(e) => setName(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>CPF:</h2>
            <input type="text" value={CPF} onChange={(e) => setCPF(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>RG:</h2>
            <input type="text" value={RG} onChange={(e) => setRG(e.target.value)}></input>
          </div>
          <h1>Endereço</h1>
          <div className="Form">
            <h2>CEP:</h2>
            <input type="text" value={CEP} onChange={(e) => setCEP(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>Logradouro:</h2>
            <input type="text" value={Logradouro} onChange={(e) => setLogradouro(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>Complemento:</h2>
            <input type="text" value={Complemento} onChange={(e) => setComplemento(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>Setor:</h2>
            <input type="text" value={Setor} onChange={(e) => setSetor(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>Cidade:</h2>
            <input type="text" value={Cidade} onChange={(e) => setCidade(e.target.value)}></input>
          </div>
          <div className="Form">
            <h2>UF:</h2>
            <select value={UF} onChange={(e) => setUF(e.target.value)}>
              {
                UFS.map((n) => {
                  return (
                    <option value={n}>{n}</option>
                  )
                })
              }
            </select>
          </div>
        </div>

        <div className="PhoneContainer">
          <div className="PhoneForms">
            <table className="Phone">
              <thead>
                <tr>
                  <td>Telefone</td>
                  <td>Descrição</td>
                </tr>
              </thead>
              {
                telefones.map((telefone, i) => {
                  return (
                    <tr key={i}>
                      <td>
                        <input
                          name="telefone"
                          value={telefone.phoneNumber}
                          onChange={(e) => {
                            let arr = [...telefones];
                            arr[i].phoneNumber = e.target.value;
                            setTelefones(arr);
                          }}
                          type="text" />
                      </td>
                      <td>
                        <input
                          name="descricao"
                          value={telefone.phoneDescription}
                          onChange={(e) => {
                            let arr = [...telefones];
                            arr[i].phoneDescription = e.target.value;
                            setTelefones(arr);
                          }}
                          type="text" />
                      </td>
                    </tr>
                  )
                })
              }
            </table>
          </div>
          <button onClick={() => setInputCount(inputCount + 1)}>Adicionar novos contatos</button>
        </div>
      </div>
      <div className="ButtonContainer">
        <button onClick={boolean ? () => teste() : () => criaObjeto()}>Gravar Dados</button>
        <button onClick={() => deletar()} disabled={deleteButton}>Excluir Dados</button>
      </div>
      {/* Parte de baixo  */}
      <div className="Footer">
        <h1>Dados gravados</h1>

        <table>
          <tr>
            <th>Nome</th>
            <th>CPF</th>
            <th>RG</th>
            <th>CEP</th>
            <th>Telefone - Descrição</th>
            <th></th>
          </tr>
          {
            dados.map((dado) => {
              return (
                <tr>
                  <td>{dado.nome}</td>
                  <td>{dado.CPF}</td>
                  <td>{dado.RG}</td>
                  <td>{dado.CEP}</td>
                  <td>{dado.Telefone.map((n) => {
                    return (
                      n.phoneNumber ?
                        <p>{n.phoneNumber + ` - ` + n.phoneDescription}</p>
                        :
                        <></>
                    )
                  })}</td>

                  <button onClick={() => editar(dado.Id)}>Editar</button>
                </tr>
              )
            })
          }
        </table>
      </div>
    </div>
  );
}

export default App;