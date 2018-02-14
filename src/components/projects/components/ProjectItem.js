import { h, Component } from "preact";
import ProjectLink from "./ProjectLink";
import ProjectName from "./ProjectName";

class ProjectItem extends Component {
  render() {
    let { project } = this.props;

    return (
      <div className="col-xs-6 col-sm-3 col-md-2">
        <div className="project">
          <ProjectName name={project.project_name} type={project.type} />
          <a
            className="project-preview"
            href={project.project_link}
            style={`background-image: url(${project.preview})`}
          />
          <ul className="buttons">
            <li className="admin">
              <ProjectLink href={project.admin} title={`Admin panel`} />
            </li>
            <li className="helper">
              <ProjectLink href={project.helper_link} title={`Helper`} />
            </li>
          </ul>
        </div>
      </div>
    );
  }
}

export default ProjectItem;
