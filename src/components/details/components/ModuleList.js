import { h, Component } from "preact";

function ModuleList({ data }) {
  return (
    <div>
      {data ? (
        <div>
          <p>Modules</p>
          <table>
            <tr>
              <th>name</th>
              <th>version</th>
            </tr>
            {data.map(item => (
              <tr>
                <td>{item.name}</td>
                <td>{item.version}</td>
              </tr>
            ))}
          </table>
        </div>
      ) : (
        ""
      )}
    </div>
  );
}

export default ModuleList;
