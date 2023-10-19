import {Link} from "react-router-dom";
import {ArticleType} from "../../types/ArticleType.ts";

export function ArticleComponent({...article}: ArticleType)
{
    return <div className="card mb-3">
        <h5 className="card-header"><Link to={article.href}>{article.title}</Link></h5>
        <div className="card-body">
            <p className="card-text">{article.contenue}</p>
            <p>{article.categories.map((category, k) => <small key={k}>
                <i className="fa-solid fa-tag"></i> <Link to={category.href}>{category.title}</Link>
            </small>)}</p>
        </div>
        <div className="card-footer">
            <div className="d-flex justify-content-sm-between">
                <div>
                    <i className="fa-solid fa-thumbs-up"></i> 4
                    <i className="fa-regular fa-thumbs-up"></i> 2
                    <i className="fa-solid fa-comment"></i>
                </div>
                <div>{new Date(article.created_at).toLocaleString()} - {new Date(article.updated_at).toLocaleString()}</div>
                <div></div>
            </div>
        </div>
    </div>
    /* <div className="card mb-3">
        <h5 className="card-header"><a>{ 'titre' }</a></h5>
        <div className="card-body">
            /* {# <h5 className="card-title">Special title treatment</h5> #}
            <p className="card-text">{{ article.contenue }}</p>
            <p>
                {% for categorie in article.categories %}
                <small><a href="{{ path('categorie.show', {id: categorie.id, slug: categorie.slug}) }}"><i className="fa-solid fa-tag"></i> {{ categorie.title }}</a></small>
                {% endfor %}
            </p>
        </div>
        <div className="card-footer">
            <div className="d-flex justify-content-between">
                <div>
                    <i className="fa-solid fa-thumbs-up"></i> 4
                    <i className="fa-regular fa-thumbs-up"></i>
                    <i className="fa-solid fa-comment"></i> {{ article.commentaires | length }}
                </div>
                <div>
                    <small className="text-muted">Création : {{ article.createdAt | date('j M Y à H:m') }}</small> |
                    <small className="text-muted">Dernière midification : {{ article.createdAt | date('j M Y à H:m') }}</small>
                </div>
                <div>
                    <i className="fa-solid fa-user"></i> {{ article.autor.username | default('Anonnyme') }}
                </div>
            </div>
        </div>
    </div>
    */
}