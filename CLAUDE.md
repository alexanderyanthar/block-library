# Blocks Library — WordPress Back-End

## Purpose
Headless WordPress CMS for a Next.js learning sandbox. The goal is to understand the headless WP + Next.js stack deeply, and to build custom Gutenberg blocks on both sides. Content is served via WPGraphQL — there is no traditional WP front-end theme in use.

Paired Next.js front-end: `/Users/alexanderyanthar/Documents/blocks-library-next`
WordPress runs via Local by Flywheel at `http://localhost:10018`.

## Installed Plugins

| Plugin | Purpose |
|---|---|
| WPGraphQL | Exposes WP data as a GraphQL API at `/graphql` |
| WPGraphQL Content Blocks | Exposes Gutenberg block data (`editorBlocks`) as structured GraphQL objects |
| WPGraphQL for ACF | Exposes ACF field groups and their values via GraphQL |
| Advanced Custom Fields (ACF) | Custom field UI for structured post meta |
| blocks-library-projects | Custom plugin — registers the `project` CPT |

## Custom Plugins (this repo)

### `plugins/blocks-library-projects/blocks-library-projects.php`
Registers the `project` custom post type. Key arguments:
- `show_in_graphql: true` — exposes to WPGraphQL
- `graphql_single_name: 'project'` / `graphql_plural_name: 'projects'`
- `rewrite: ['slug' => 'projects']` — URL namespace is `/projects/*`
- Supports: title, editor, excerpt, thumbnail

No class, no autoloader — a single-file plugin is correct for a CPT registration.

## ACF Field Groups

### Page Hero
- **Attached to:** Pages (post type: page)
- **Fields:**
  - `heroTitle` — Text
  - `heroSubtitle` — Text
  - `heroBackgroundColour` — Color Picker (note: British spelling — field was named before rename; the GraphQL key is `heroBackgroundColour`)
- Exposed via WPGraphQL for ACF. Queried in `GetPageBySlug.ts` on the Next.js side.

## WPGraphQL Notes

### idType by post type
- **Pages** use `idType: URI` in GraphQL queries
- **Custom post types** (including `project`) use `idType: SLUG`
- Using SLUG on pages throws `Value "SLUG" does not exist in "PageIdType" enum`

### editorBlocks
WPGraphQL Content Blocks exposes Gutenberg blocks as `editorBlocks` — a **flat list** of all blocks including nested children. Each block also has `innerBlocks` for the nested tree structure. On the Next.js side, only top-level container types are added to `blockMap`; child-only types are intentionally omitted.

### GraphiQL IDE
Available at `http://localhost:10018/graphql` (GET in browser) or via the WPGraphQL menu in wp-admin. Use this to test queries before writing them in TypeScript.

## Permalink / Rewrite Note
After activating any plugin that registers a CPT, visit **Settings → Permalinks** in wp-admin and hit Save (no change needed) to flush rewrite rules. Otherwise CPT archive and single URLs return 404.

## Current open problem — core/accordion (WordPress 6.9)
`CoreAccordionHeading` has no usable text attribute in WPGraphQL — `level` and `className` are null. The heading text is only available via `renderedHtml`, which includes WordPress's full button HTML markup. Decision pending on Next.js side:
- **A** — Use renderedHtml + React state
- **B** — Parse title from renderedHtml with regex
- **C** — Build a custom accordion Gutenberg block (clean attributes, recommended)

## What's not built yet
- Any custom Gutenberg blocks (the next major milestone)
- Navigation/menu exposed via GraphQL
- Any REST API endpoints (REST is preferred over GraphQL for form submissions and mutations)
