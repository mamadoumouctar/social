import {useParams} from "react-router-dom";

export function ShowArticle()
{
    const query = useParams()
    return <div>
        <h1>Detail de {query.id} {query.slug}</h1>
    </div>
}
