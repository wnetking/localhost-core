import { h } from "preact";

export default function ProjectLink({ href, title }) {
  return <a href={href ? href : "#"} title={title} />;
}
