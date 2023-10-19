import {useEffect, useState} from "react";
import {ArticleType} from "../../types/ArticleType.ts";
import {ArticleComponent} from "../../components/article/ArticleComponent.tsx";

export function Index()
{
    const [articles, setArticles] = useState<ArticleType[]>([])
    useEffect(() => {
        fetch('http://localhost:8000/api/articles', {
            method: 'GET',
            headers: {
                'Accept': 'application/json'
            }
        }).then(d => {
            if(d.ok){
                return d.json()
            }
            throw new Error("Impossible d'effectuer la récupération")
        }).then(setArticles)
    }, [])

    return <div>
        <h1>Tout les Articles</h1>
        {articles.map((article, k) => <ArticleComponent key={k} {...article} />)}
    </div>
}
