export type APISchemas = {
  Article: {
    /*
     * Format: int64
     * @example 1
     */
    id?: number
    /* @example Article 1 */
    title?: string
  }
}

export type APIEndpoints = {
  "/api/articles": {
    responses: { get: Array<APISchemas["Article"]> }
    requests: { method?: "get" }
  }
  "/api/articles/{slug}-{id}": {
    responses: { get: APISchemas["Article"] }
    requests: {
      method?: "get"
      urlParams: {
        /* Format: int64 */
        id: number
        slug: string
      }
    }
  }
}

export type APIPaths = keyof APIEndpoints

export type APIRequests<T extends APIPaths> = APIEndpoints[T]["requests"]

export type APIMethods<T extends APIPaths> = NonNullable<
  APIRequests<T>["method"]
>

export type APIRequest<T extends APIPaths, M extends APIMethods<T>> = Omit<
  {
    [MM in APIMethods<T>]: APIRequests<T> & { method: MM }
  }[M],
  "method"
> & { method?: M }

type DefaultToGet<T extends string | undefined> = T extends string ? T : "get"

export type APIResponse<
  T extends APIPaths,
  M extends string | undefined
> = DefaultToGet<M> extends keyof APIEndpoints[T]["responses"]
  ? APIEndpoints[T]["responses"][DefaultToGet<M>]
  : never
