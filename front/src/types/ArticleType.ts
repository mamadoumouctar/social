export interface ArticleType{
    title: string,
    contenue: string,
    categories: [{
        id: bigint,
        title: string,
        href: string
    }],
    created_at: string,
    updated_at: string,
    href: string
}
