import {h, Component} from 'preact';
import Project from './Project'


class ProjectList extends Component {
  render() {
    return (
      <div className="row">
        {this.props.data.map((item)=> (
          <Project project={item}/>
        ))}
      </div>
    );
  }
}

export default ProjectList;
